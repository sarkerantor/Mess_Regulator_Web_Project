<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['mail'])){ header("Location: login.php"); exit(); }

$email = $_SESSION['mail'];
$curr_val = $_SESSION['curval'];
$admin_id = $_SESSION['id'];

$utility_table = $curr_val . "_utility_" . $admin_id;
$meal_table = $curr_val . $admin_id;

$members_res = $con->query("SELECT name, contact FROM `$meal_table` ");
if($members_res && $members_res->num_rows > 0){
    while($m = $members_res->fetch_assoc()){
        $m_name = mysqli_real_escape_string($con, $m['name']);
        $m_con = mysqli_real_escape_string($con, $m['contact']);
        
        $con->query("INSERT IGNORE INTO `$utility_table` (name, contact) VALUES ('$m_name', '$m_con')");
    }
}

if(isset($_POST['update_utility'])){
    $u_id = (int)$_POST['u_id'];
    $field = mysqli_real_escape_string($con, $_POST['field']); 
    $val = mysqli_real_escape_string($con, $_POST['value']);
    
    $con->query("UPDATE `$utility_table` SET `$field` = '$val' WHERE id = $u_id");
    exit; 
}

$data = $con->query("SELECT * FROM `$utility_table` ORDER BY name ASC");

$total_house = 0; $total_elect = 0; $total_inter = 0; 
$total_gas = 0; $total_garb = 0; $total_chef = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Utility Bills - <?php echo strtoupper($curr_val); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-size: 0.95rem; }
        .card { border-radius: 12px; border: none; }
        .table thead { background-color: #343a40; color: white; white-space: nowrap; }
        
        input[type="number"] { 
            width: 95px; border: 2px solid #dee2e6; border-radius: 6px; 
            padding: 4px; text-align: center; font-weight: bold; margin-bottom: 5px;
        }

        .status-select {
            width: 95px; padding: 5px; border-radius: 6px; 
            font-weight: bold; cursor: pointer; text-align: center; 
            border: 2px solid; transition: all 0.3s ease;
        }
        
        /* Due: Red Border, Light BG */
        .bg-due { background-color: #fff5f5; color: #dc3545; border-color: #dc3545; }
        
        /* Paid: Solid Green BG, White Text */
        .bg-paid { background-color: #198754 !important; color: white !important; border-color: #198754; }

        .footer-sum { background-color: #212529 !important; color: #f8f9fa; font-weight: bold; font-size: 1.1rem; }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="card shadow p-3 p-md-4">
        <h3 class="fw-bold text-center text-primary mb-4">
            <i class="fa-solid fa-file-invoice-dollar me-2"></i> Monthly Utility Bills: <?php echo strtoupper($curr_val); ?>
        </h3>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        <th>Contact</th>
                        <th>House Rent (৳)</th>
                        <th>Electric (৳)</th>
                        <th>Internet (৳)</th>
                        <th>Gas (৳)</th>
                        <th>Garbage (৳)</th>
                        <th>Chef (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data && $data->num_rows > 0): ?>
                        <?php while($row = $data->fetch_assoc()): 
                            $total_house += (int)$row['house_rent'];
                            $total_elect += (int)$row['electric_bill'];
                            $total_inter += (int)$row['internet_bill'];
                            $total_gas += (int)$row['gas_bill'];
                            $total_garb += (int)$row['garbage_bill'];
                            $total_chef += (int)$row['shef_bill'];
                        ?>
                        <tr>
                            <td class="text-start ps-3 fw-bold"><?php echo $row['name']; ?></td>
                            <td class="text-muted small"><?php echo $row['contact']; ?></td>
                            
                            <?php 
                            $cols = [
                                ['amt'=>'house_rent', 'stat'=>'h_status'],
                                ['amt'=>'electric_bill', 'stat'=>'e_status'],
                                ['amt'=>'internet_bill', 'stat'=>'i_status'],
                                ['amt'=>'gas_bill', 'stat'=>'g_status'],
                                ['amt'=>'garbage_bill', 'stat'=>'gr_status'],
                                ['amt'=>'shef_bill', 'stat'=>'s_status']
                            ];

                            foreach($cols as $col): 
                                $status_val = $row[$col['stat']];
                                $status_class = ($status_val == 'Paid') ? 'bg-paid' : 'bg-due';
                            ?>
                            <td>
                                <input type="number" onchange="updateData(<?php echo $row['id']; ?>, '<?php echo $col['amt']; ?>', this.value)" value="<?php echo (int)$row[$col['amt']]; ?>">
                                <select onchange="updateData(<?php echo $row['id']; ?>, '<?php echo $col['stat']; ?>', this.value); updateStyle(this)" class="status-select <?php echo $status_class; ?>">
                                    <option value="Due" <?php echo ($status_val == 'Due') ? 'selected' : ''; ?>>Due</option>
                                    <option value="Paid" <?php echo ($status_val == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                                </select>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endwhile; ?>
                        
                        <tr class="footer-sum">
                            <td colspan="2" class="text-end pe-4">Total Monthly Collection:</td>
                            <td><?php echo $total_house; ?></td>
                            <td><?php echo $total_elect; ?></td>
                            <td><?php echo $total_inter; ?></td>
                            <td><?php echo $total_gas; ?></td>
                            <td><?php echo $total_garb; ?></td>
                            <td><?php echo $total_chef; ?></td>
                        </tr>

                    <?php else: ?>
                        <tr><td colspan="8" class="py-4">No members found. Please add members to your mess first.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-4 d-flex justify-content-center gap-2">
            <a href="dashboard.php" class="btn btn-dark fw-bold px-5 py-2 shadow-sm">
                <i class="fa-solid fa-house me-2"></i> Dashboard
            </a>
            <button onclick="window.location.reload()" class="btn btn-primary fw-bold px-4 shadow-sm">
                <i class="fa-solid fa-sync-alt me-2"></i> Update Sum
            </button>
        </div>
    </div>
</div>

<script>
function updateData(id, field, value) {
    let formData = new FormData();
    formData.append('update_utility', true);
    formData.append('u_id', id);
    formData.append('field', field);
    formData.append('value', value);

    fetch('utility.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        console.log('Saved');
    }).catch(err => console.error(err));
}

function updateStyle(el) {
    if(el.value === 'Paid') {
        el.classList.remove('bg-due');
        el.classList.add('bg-paid');
    } else {
        el.classList.remove('bg-paid');
        el.classList.add('bg-due');
    }
}
</script>

</body>
</html>