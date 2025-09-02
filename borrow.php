<?php
session_start();
include "db.php";

// $_GET yazım hatası düzeltildi
if(isset($_GET['book_id']) && !empty($_GET['book_id'])){
    $book_id = (int)$_GET['book_id']; // Güvenlik için integer'a çevir
} else {
    // book_id yoksa ana sayfaya yönlendir
    header("Location: index.php");
    exit();
}

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    if($_SESSION['role'] == "user"){
        // SQL syntax düzeltildi
        $sql = "INSERT INTO transactions (
            user_id,
            book_id,
            issue_date,
            status
        ) VALUES (
            '$user_id',
            '$book_id',
            CURDATE(),
            'borrowed'
        )";

        $result = mysqli_query($conn, $sql);
        if($result){
            $sql2 = "update books set quantity = quantity - 1 where id = '$book_id'";
          $result2 = mysqli_query($conn, $sql2);  
            // HTML hata düzeltildi: hrf -> href
            echo "Talebiniz kütüphaneciye gönderildi! <a href='index.php'>Geri dön</a>";
        } else {
            echo "Hata!: " . mysqli_error($conn);
        }
    } else {
        header("Location: admin/dashboard.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>