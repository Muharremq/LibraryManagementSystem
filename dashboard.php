<?php 
include "db.php";
session_start();

$error_message = "";
$success_message = "";

if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "user"){
        // Kullanıcı için kitapları listele
        $sql = "SELECT * FROM books WHERE quantity > 0 ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        
        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
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
    <title>Document</title>
</head>
<body>
<a href="logout.php" class="logout-btn" onclick="return confirm('Çıkış yapmak istediğinizden emin misiniz?')">
                    Çıkış Yap
                </a>
            </body>
</html>