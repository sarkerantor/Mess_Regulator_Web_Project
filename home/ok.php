<?php
    session_start();
    include "../config/db.php";

    if (!isset($_GET['okid'])) {
        header("Location: monthly_report.php");
        exit();
    }

    $okid  = intval($_GET['okid']);
    $curval = $_SESSION['curval'];
    $id     = $_SESSION['id'];

    $deposit  = $curval . "deposit" . $id;
    $curmonth = $curval . $id;

    //  Get member info from current month table
    $sql = "SELECT name, contact FROM $curmonth WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $okid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        header("Location: monthly_report.php");
        exit();
    }

    $row = $result->fetch_assoc();
    $name    = $row['name'];
    $contact = $row['contact'];

    //  Update status = 1 in current month table
    $updateStatus = "UPDATE $curmonth SET status = 1 WHERE id = ?";
    $stmt1 = $con->prepare($updateStatus);
    $stmt1->bind_param("i", $okid);
    $stmt1->execute();

    //  Update deposit balance = 0
    $updateBalance = "UPDATE $deposit 
                      SET balance = 0 
                      WHERE name = ? AND contact = ?";
    $stmt2 = $con->prepare($updateBalance);
    $stmt2->bind_param("ss", $name, $contact);
    $stmt2->execute();

    //  Redirect back
    header("Location: monthly_report.php");
    exit();
?>