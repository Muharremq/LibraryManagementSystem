<!-- navbar.php -->
<style>
    .navbar {
        background-color: #343a40;
        padding: 0;
        margin: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }
    
    .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }
    
    .navbar-brand {
        color: #ffffff;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
        padding: 15px 0;
    }
    
    .navbar-nav {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
    }
    
    .nav-item {
        margin: 0;
    }
    
    .nav-link {
        color: #ffffff;
        text-decoration: none;
        padding: 15px 20px;
        display: block;
        transition: background-color 0.3s ease;
        border-radius: 4px;
        margin: 0 5px;
    }
    
    .nav-link:hover {
        background-color: #495057;
        color: #ffffff;
    }
    
    .nav-link.active {
        background-color: #007bff;
    }
    
    .logout-btn {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .logout-btn:hover {
        background-color: #c82333;
        color: white;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .navbar-container {
            flex-direction: column;
            padding: 10px;
        }
        
        .navbar-nav {
            flex-direction: column;
            width: 100%;
            margin-top: 10px;
        }
        
        .nav-item {
            width: 100%;
        }
        
        .nav-link {
            text-align: center;
            margin: 2px 0;
        }
    }
    
    /* Body margin for fixed navbar */
    body {
        margin-top: 70px;
    }
    
    @media (max-width: 768px) {
        body {
            margin-top: 120px;
        }
    }
</style>

<nav class="navbar">
    <div class="navbar-container">
        <a href="dashboard.php" class="navbar-brand">Admin Panel</a>
        
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                    📚 Kitaplar
                </a>
            </li>
            <li class="nav-item">
                <a href="view_transaction.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'view_transaction.php') ? 'active' : ''; ?>">
                    📋 İşlemler
                </a>
            </li>
            <li class="nav-item">
                <a href="add_book.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add_book.php') ? 'active' : ''; ?>">
                    ➕ Kitap Ekle
                </a>
            </li>
            <li class="nav-item">
                <a href="manage_users.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_users.php') ? 'active' : ''; ?>">
                    👥 Kullanıcılar
                </a>
            </li>
            <li class="nav-item">
                <a href="../logout.php" class="logout-btn">🚪 Çıkış</a>
            </li>
        </ul>
    </div>
</nav>