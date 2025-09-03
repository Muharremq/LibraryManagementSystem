<?php
include "db.php";

$error_message = "";
$success_message = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    // Basit validasyon
    if(empty($name) || empty($email) || empty($password)){
        $error_message = "Lütfen tüm alanları doldurun!";
    } elseif(strlen($password) < 6){
        $error_message = "Şifre en az 6 karakter olmalıdır!";
    } else {
        // Email'in daha önce kullanılıp kullanılmadığını kontrol et
        $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_email_sql);
        
        if($check_result && $check_result->num_rows > 0){
            $error_message = "Bu email adresi zaten kullanılıyor!";
        } else {
            // Kullanıcıyı kaydet
            $sql = "INSERT INTO users(name, email, password, role) VALUES('$name', '$email', '$password', '$role')";
            $result = mysqli_query($conn, $sql);
            
            if($result){
                $success_message = "Kayıt başarılı! Giriş yapabilirsiniz.";
                // Formu temizle
                $name = $email = $password = "";
                header("Location: login.php");
            } else {
                $error_message = "Kayıt sırasında hata oluştu: " . mysqli_error($conn);
            }
        }
    }
}
?>

<?php require 'view/partial/header.php'?>

<body>
    <div class="register">
        <h2>Hesap Oluştur</h2>
        
        <?php if(!empty($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            <input type="text" name="name" placeholder="Ad Soyad" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            <input type="email" name="email" placeholder="E-posta" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <input type="password" name="password" placeholder="Şifre (en az 6 karakter)" required>
            <input type="text" name="role" value="user" hidden>
            <button type="submit">Kayıt Ol</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="login.php" style="color: #3498db; text-decoration: none;">Zaten hesabınız var mı? Giriş yapın</a>
        </div>
    </div>
</body>
</html>