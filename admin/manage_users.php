<?php
session_start();

$error_message = "";
$success_message = "";

if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        include "../db.php";
        $sql = "SELECT id, name, email, role FROM users WHERE role = 'user'";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }
    } else {
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi - Library</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <!-- Hata mesajları -->
    <?php if(!empty($error_message)): ?>
        <div class="message error" style="max-width: 1200px; margin: 0 auto 20px auto; padding: 12px 16px; border-radius: 6px; background: #fadbd8; color: #e74c3c; border: 1px solid #e74c3c; text-align: center;">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <div class="table-wrapper">
        <table class="view-books">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>İsim</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td>
                                <a href="delete_user.php?user_id=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')" 
                                   class="btn-delete">
                                   Kullanıcıyı Sil
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-state">
                            <h3>Henüz kullanıcı yok</h3>
                            <p>Sistem kullanıcıları burada görünecek</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>