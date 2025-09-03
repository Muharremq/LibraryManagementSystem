<?php
include "../db.php";
session_start();

$error_message = "";
$success_message = "";

// Kullanıcı girişi ve yetki kontrolü
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        // Admin yetkisi var, kitapları listele
        $sql = "SELECT * FROM books ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }
        
        // Kitap silme işlemi
        if(isset($_GET['delete_id'])){
            $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
            
            // Önce resim dosyasını bul ve sil
            $image_sql = "SELECT image FROM books WHERE id = '$delete_id'";
            $image_result = mysqli_query($conn, $image_sql);
            
            if($image_result && mysqli_num_rows($image_result) > 0){
                $book_data = mysqli_fetch_assoc($image_result);
                if(!empty($book_data['image'])){
                    $image_path = "../image/" . $book_data['image'];
                    if(file_exists($image_path)){
                        unlink($image_path);
                    }
                }
            }
            
            // Kitabı veritabanından sil
            $delete_sql = "DELETE FROM books WHERE id = '$delete_id'";
            $delete_result = mysqli_query($conn, $delete_sql);
            
            if($delete_result){
                $success_message = "Kitap başarıyla silindi!";
                // Sayfayı yeniden yükle
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "Kitap silinirken hata oluştu: " . mysqli_error($conn);
            }
        }
    } else {
        // Admin değilse user dashboard'a yönlendir
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    // Giriş yapmamışsa login sayfasına yönlendir
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style type="text/css">
        .adminnavbar{
            display: flex;
            width: 200px;
            flex-direction: column;
            background-color: green;
            color:white;
        }
        .adminnavbar a{
            color: white;
            text-decoration: none;

        }
        .adminnavbar ul li{
            list-style: none;
        }

    </style>
</head>
<body>
    <nav class="adminnavbar">
        <ul>
            <li> <a href="view_transaction.php">view transaction</a></li>
            <li><a href="manage_users.php"> manage users</a></li>
            <li> <a href="add_book.php"> Add books</a></li>
            <li> <a href="view_books.php"> View Books</a></li>
        </ul>
    </nav>
    <a href="../logout.php"> Log out</a>
</body>
</html>