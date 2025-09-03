<?php
session_start();
include "../db.php";
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        if(isset($_GET['transaction_id'])){
            $transaction_id = $_GET['transaction_id'];

                    if(isset($_POST['submit'])){
            $return_date = $_POST['return_date'];
            $status = $_POST['status'];

            $sql = "update transactions set return_date = '$return_date', status='$status' where id = '$transaction_id'";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }else {
            header("Location: view_transaction.php");
        }
        }
        }else{
            header("Location: view_transaction.php");
        }
}else {
    header("Location: ../dashboard.php");
    }
}else{
    header("Location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="update_transactions.php?transaction_id= <?= $transaction_id?>" method="post">

    <input type="text" name="return_date" required placeholder="date-format: 2025-03-04" >
    <select name="status">
        <option value="borrowed">borrowed</option>
        <option value="returned">returned</option>
    </select>

    <input type="submit" name="submit" >
    </form>
</body>
</html>