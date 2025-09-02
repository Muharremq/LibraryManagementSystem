<?php
session_start();
include "../db.php";
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        $sql = "SELECT * FROM transactions ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }else {

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
    <title>library</title>
        <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <table class="view-books">
        <thead>
            <tr>
                <th>user id</th>
                <th>book id</th>
                <th>issue date</th>
                <th>return date</th>
                <th>status</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)){
                    
                
                 ?>
                <tr>
                    <td><?= "{$row['user_id']}";?>  </td>
                    <td><?= "{$row['book_id']}";?>  </td>
                    <td><?= "{$row['issue_date']}";?>  </td>
                    <td><?= "{$row['return_date']}";?>  </td>
                    <td><?= "{$row['status']}";?>  </td>
                    <td><a class="update" href="update_transactions.php?transaction_id=<?=$row['id'];?>">update</a></td>
                    <td><a class="delete" href="delete_transactions.php?transaction_id=<?=$row['id'];?>">delete</a></td>
                </tr>
                <?php }?>
            </tbody>
        </thead>
    </table>
</body>
</html>