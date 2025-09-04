<?php
include "../db.php";
session_start();

$error_message = "";
$success_message = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if($result && $result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        
        // Şifre karşılaştırması - buradaki hatayı düzelttik
        if($row['password'] == $password){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            if($row['role'] == "admin"){
                header("Location: ../admin/book/view_books.php");

            }else{
                header("Location: ../dashboard.php");
            }

            exit();
        } else {
            $error_message = "Yanlış şifre!";
        }
    } else {
        $error_message = "Bu email adresi ile kayıtlı kullanıcı bulunamadı!";
    }
}
?>

<?php require '../view/partial/header.php'?>

<body>
    <div class="register">
        <h2>Giriş Yap</h2>
        
        <?php if(!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="E-posta" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <button type="submit">Giriş Yap</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="register.php" style="color: #3498db; text-decoration: none;">Hesabınız yok mu? Kayıt olun</a>
        </div>
    </div>
</body>
</html>