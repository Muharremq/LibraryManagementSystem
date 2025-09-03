<?php
session_start();
include "../../db.php";
if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        // Düzeltilmiş SQL sorgusu - JOIN kullanarak iki tabloyu birleştirme
        $sql = "SELECT ta.*, u.name 
                FROM transactions as ta 
                JOIN users as u ON ta.user_id = u.id";
        
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }
    } else {
        header("Location: ../dashboard.php");
    }
} else {
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
    <?php require "../../view/partial/admin_navbar.php";?>
</head>
<body>
    <table class="view-books">
        <thead>
            <tr>
                <th>User Name</th> <!-- Kullanıcı adı için yeni sütun -->
                <th>User ID</th>
                <th>Book ID</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($result) && mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td> <!-- Kullanıcı adı -->
                    <td><?= htmlspecialchars($row['user_id']); ?></td>
                    <td><?= htmlspecialchars($row['book_id']); ?></td>
                    <td><?= htmlspecialchars($row['issue_date']); ?></td>
                    <td><?= htmlspecialchars($row['return_date']); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><a class="update" href="update_transactions.php?transaction_id=<?= $row['id']; ?>">Update</a></td>
                    <td><a class="delete" href="delete_transactions.php?transaction_id=<?= $row['id']; ?>">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Kayıt bulunamadı</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>