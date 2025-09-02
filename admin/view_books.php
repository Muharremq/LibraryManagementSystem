<?php
session_start();


if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == "admin"){
        include "../db.php";
        $sql = "SELECT * FROM books ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if(!$result){
            $error_message = "Veritabanı hatası: " . mysqli_error($conn);
        }else {

        }
}else {
    header("Location: ../dashboard.php");
}





$error_message = "";
$success_message = "";

}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Listesi - Library</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="page-header">
        <h1>Kitap Listesi</h1>
        <p>Kütüphanedeki tüm kitapları görüntüleyin</p>
    </div>

    <!-- Hata mesajları -->
    <?php if(!empty($error_message)): ?>
        <div class="message error" style="max-width: 1200px; margin: 0 auto 20px auto; padding: 12px 16px; border-radius: 6px; background: #fadbd8; color: #e74c3c; border: 1px solid #e74c3c; text-align: center;"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- İstatistik kartları -->
    <?php if($result && $result->num_rows > 0): ?>
        <?php
        // İstatistikleri hesapla
        $total_books = $result->num_rows;
        $total_quantity = 0;
        $low_stock_count = 0;
        $out_of_stock_count = 0;
        
        mysqli_data_seek($result, 0);
        while($stat_row = mysqli_fetch_assoc($result)) {
            $total_quantity += (int)$stat_row['quantity'];
            if($stat_row['quantity'] == 0) {
                $out_of_stock_count++;
            } elseif($stat_row['quantity'] <= 5) {
                $low_stock_count++;
            }
        }
        mysqli_data_seek($result, 0);
        ?>
        
        <div class="stats-cards">
            <div class="stat-card total">
                <h3><?php echo $total_books; ?></h3>
                <p>Toplam Kitap Türü</p>
            </div>
            <div class="stat-card available">
                <h3><?php echo $total_quantity; ?></h3>
                <p>Toplam Stok</p>
            </div>
            <div class="stat-card low-stock">
                <h3><?php echo $low_stock_count; ?></h3>
                <p>Düşük Stok</p>
            </div>
            <div class="stat-card out-of-stock">
                <h3><?php echo $out_of_stock_count; ?></h3>
                <p>Stokta Yok</p>
            </div>
        </div>
    <?php endif; ?>

    <div class="table-wrapper">
        <table class="view-books">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Başlık</th>
                    <th>Yazar</th>
                    <th class="isbn-column">ISBN</th>
                    <th>Kapak</th>
                    <th>Stok</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="isbn-column"><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td>
                                <?php if(!empty($row['image'])): ?>
                                    <?php $image_path = "../image/" . $row['image']; ?>
                                    <?php if(file_exists($image_path)): ?>
                                        <img src="<?php echo $image_path; ?>" 
                                             alt="<?php echo htmlspecialchars($row['title']); ?>" 
                                             class="book-image">
                                    <?php else: ?>
                                        <div class="no-image">Resim<br>Bulunamadı</div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="no-image">Resim<br>Yok</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                $quantity = (int)$row['quantity'];
                                if($quantity == 0): ?>
                                    <span class="quantity-badge out-of-stock"><?php echo $quantity; ?></span>
                                <?php elseif($quantity <= 5): ?>
                                    <span class="quantity-badge low-stock"><?php echo $quantity; ?></span>
                                <?php else: ?>
                                    <span class="quantity-badge"><?php echo $quantity; ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="view_book.php?id=<?php echo $row['id']; ?>" class="btn btn-view">Görüntüle</a>
                                    <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Düzenle</a>
                                    <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" 
                                       onclick="return confirm('<?php echo addslashes($row['title']); ?> kitabını silmek istediğinizden emin misiniz?')">Sil</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="empty-state">
                            <h3>Henüz kitap eklenmemiş</h3>
                            <p>Kütüphaneye kitap eklemek için aşağıdaki butona tıklayın</p>
                            <a href="add_book.php" class="btn">İlk Kitabı Ekle</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Floating Add Button -->
    <div class="floating-add">
        <a href="add_book.php" class="fab" title="Yeni Kitap Ekle">
            <span>+</span>
        </a>
    </div>
</body>
</html>