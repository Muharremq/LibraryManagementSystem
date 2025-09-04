<?php
session_start();
include "../../db.php";

$result = null;
$error_message = "";

// Oturum ve yetki kontrolü
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION['role'] != "admin"){
    header("Location: ../dashboard.php");
    exit();
}

// LEFT JOIN kullanarak tüm transaction kayıtlarını getir
// Kullanıcı silinmiş olsa bile transaction verisi görünecek
$sql = "SELECT ta.*, 
               COALESCE(u.name, CONCAT('Silinmiş Kullanıcı (ID: ', ta.user_id, ')')) as user_name,
               u.id as user_exists
        FROM transactions as ta 
        LEFT JOIN users as u ON ta.user_id = u.id 
        ORDER BY ta.id DESC";

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
    <title>İşlem Geçmişi - Library</title>
    <link rel="stylesheet" href="admin_style.css">
    <?php require "../../view/partial/admin_navbar.php";?>
    <style>
        .deleted-user {
            color: #dc3545;
            font-style: italic;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-borrowed {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-returned {
            background-color: #d4edda;
            color: #155724;
        }
        .status-overdue {
            background-color: #f8d7da;
            color: #721c24;
        }
        .page-header {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .stats-summary {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            gap: 15px;
        }
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            flex: 1;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px 0;
        }
        .view-books {
            width: 100%;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>📚 İşlem Geçmişi</h1>
        <p>Tüm kitap ödünç alma ve iade işlemlerini görüntüleyin</p>
    </div>

    <!-- Hata Mesajı -->
    <?php if(!empty($error_message)): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: center;">
            <strong>⚠️ Hata:</strong> <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <?php if($result): ?>
        <?php 
        // İstatistikleri hesapla
        $total_transactions = mysqli_num_rows($result);
        $borrowed_count = 0;
        $returned_count = 0;
        $deleted_users_count = 0;
        
        if($total_transactions > 0) {
            mysqli_data_seek($result, 0);
            while($stat_row = mysqli_fetch_assoc($result)) {
                if($stat_row['status'] == 'borrowed') $borrowed_count++;
                if($stat_row['status'] == 'returned') $returned_count++;
                if($stat_row['user_exists'] === null) $deleted_users_count++;
            }
            mysqli_data_seek($result, 0);
        }
        ?>

        <!-- İstatistik Kartları -->
        <div class="stats-summary">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_transactions; ?></div>
                <div class="stat-label">Toplam İşlem</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $borrowed_count; ?></div>
                <div class="stat-label">Ödünç Alınan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $returned_count; ?></div>
                <div class="stat-label">İade Edilen</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $deleted_users_count; ?></div>
                <div class="stat-label">Silinmiş Kullanıcı</div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Ana Tablo -->
    <div class="table-container">
        <table class="view-books">
            <thead>
                <tr>
                    <th>İşlem ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>Kullanıcı ID</th>
                    <th>Kitap ID</th>
                    <th>Ödünç Tarihi</th>
                    <th>İade Tarihi</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <?php 
                        $is_deleted_user = ($row['user_exists'] === null);
                        $status_class = 'status-' . strtolower($row['status']);
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['id']); ?></strong></td>
                            <td class="<?= $is_deleted_user ? 'deleted-user' : ''; ?>">
                                <?= htmlspecialchars($row['user_name']); ?>
                                <?php if($is_deleted_user): ?>
                                    <br><small>⚠️ Bu kullanıcı silinmiş</small>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['user_id']); ?></td>
                            <td><?= htmlspecialchars($row['book_id']); ?></td>
                            <td><?= htmlspecialchars(date('d.m.Y', strtotime($row['issue_date']))); ?></td>
                            <td>
                                <?php if($row['return_date']): ?>
                                    <?= htmlspecialchars(date('d.m.Y', strtotime($row['return_date']))); ?>
                                <?php else: ?>
                                    <em style="color: #666;">Henüz iade edilmedi</em>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge <?= $status_class; ?>">
                                    <?php 
                                    switch($row['status']) {
                                        case 'borrowed': echo 'Ödünç Alındı'; break;
                                        case 'returned': echo 'İade Edildi'; break;
                                        case 'overdue': echo 'Gecikmiş'; break;
                                        default: echo ucfirst($row['status']); break;
                                    }
                                    ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="update_transactions.php?transaction_id=<?= $row['id']; ?>" 
                                       class="btn btn-edit" 
                                       style="padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                        ✏️ Düzenle
                                    </a>
                                    <a href="delete_transactions.php?transaction_id=<?= $row['id']; ?>" 
                                       class="btn btn-delete" 
                                       style="padding: 6px 12px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;"
                                       onclick="return confirm('Bu işlem kaydını silmek istediğinizden emin misiniz?\n\nİşlem ID: <?= $row['id']; ?>\nKullanıcı: <?= addslashes($row['user_name']); ?>')">
                                        🗑️ Sil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                            <div style="font-size: 48px; margin-bottom: 20px;">📋</div>
                            <h3 style="margin: 0 0 10px 0;">Henüz işlem kaydı yok</h3>
                            <p style="margin: 0;">Kitap ödünç alma işlemleri burada görüntülenecek</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>