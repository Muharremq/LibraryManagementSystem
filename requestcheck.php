<?php 
include "db.php";
session_start();

$error_message = "";
$success_message = "";

if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "user"){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM transactions where user_id='$user_id'";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }else {

        }
    } else {
        // Admin ise admin dashboard'a yönlendir
        header("Location: admin/dashboard.php");
        exit();
    }
} else {
    // Giriş yapmamışsa login sayfasına yönlendir
    header("Location: login.php");
    exit();
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
                </tr>
                <?php }?>
            </tbody>
        </thead>
    </table>
</body>
</html>