<?php
include "db.php";
$sql = "SELECT * FROM books ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(!$result){
      $error_message = "Veritabanı hatası: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kütüphane Ana Sayfası</title>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            overflow-x: hidden;
        }
        
        header{
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 30px;
            background-color: #333;
            color: white;
            font-size: 24px;
            font-weight: bold;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        footer{
            position: fixed;
            bottom: 0;
            background-color: #333;
            color: white;
            padding: 15px;
            width: 100%;
            text-align: center;
            z-index: 1000;
        }
        
        .content-wrapper {
            margin-top: 80px;
            margin-bottom: 80px;
            padding: 20px;
        }
        
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .book-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
        }
        
        .book-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .no-image {
            width: 100%;
            height: 200px;
            background-color: #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .book-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        
        .book-author {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        
        .book-isbn {
            font-size: 12px;
            color: #888;
            margin-bottom: 10px;
        }
        
        .quantity-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            background-color: #28a745;
        }
        
        .quantity-badge.low-stock {
            background-color: #ffc107;
            color: #333;
        }
        
        .quantity-badge.out-of-stock {
            background-color: #dc3545;
        }
        
        .error-message {
            text-align: center;
            color: #dc3545;
            font-size: 18px;
            margin: 50px 0;
        }
        
        .no-books {
            text-align: center;
            color: #666;
            font-size: 18px;
            margin: 50px 0;
        }
    </style>
</head>
<body>
    <header>Kütüphane Ana Sayfası</header>
    
    <div class="content-wrapper">
        <?php if(isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php elseif($result && $result->num_rows > 0): ?>
            <div class="books-grid">
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="book-card">
                        <?php if(!empty($row['image'])): ?>
                            <?php 
                            // Resim yolu düzeltmesi - image klasörü aynı dizinde olmalı
                            $image_path = "image/" . $row['image']; 
                            ?>
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
                        
                        <div class="book-title"><?php echo htmlspecialchars($row['title']); ?></div>
                        <div class="book-author"><?php echo htmlspecialchars($row['author']); ?></div>
                        <div class="book-isbn">ISBN: <?php echo htmlspecialchars($row['isbn']); ?></div>
                        
                        <div>
                            <?php 
                            $quantity = (int)$row['quantity'];
                            if($quantity == 0): ?>
                                <span class="quantity-badge out-of-stock">Stokta Yok</span>
                            <?php elseif($quantity <= 5): ?>
                                <span class="quantity-badge low-stock"><?php echo $quantity; ?> Adet</span>
                            <?php else: ?>
                                <span class="quantity-badge"><?php echo $quantity; ?> Adet</span>
                            <?php endif; ?>
                        </div>
                        <a href="borrow.php?book_id= <?="{$row['id']}";?>">Borrow</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-books">Henüz hiç kitap eklenmemiş.</div>
        <?php endif; ?>
    </div>

<?php require 'view/partial/footer.php';?>
</body>
</html>