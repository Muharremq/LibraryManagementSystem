<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Navbar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- navbar.php -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 70px;
            background: #ecf0f1;
            min-height: 100vh;
        }

        .navbar {
            background: #2c3e50;
            padding: 0;
            margin: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 3px solid #34495e;
        }
        
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            height: 70px;
        }
        
        .navbar-brand {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            padding: 15px 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #3498db;
            transform: translateY(-1px);
        }
        
        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
            gap: 5px;
        }
        
        .nav-item {
            margin: 0;
        }
        
        .nav-link {
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link:hover {
            background: #34495e;
            color: #3498db;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
        }
        
        .nav-link.active {
            background: #3498db;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
        }

        .nav-link.active:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 15px;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.2);
        }
        
        .logout-btn:hover {
            background: #c0392b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .logout-btn:active {
            transform: translateY(0);
            background: #a93226;
        }

        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #ffffff;
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: #34495e;
        }

        /* Content area for demo */
        .main-content {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        /* Demo card */
        .demo-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #ecf0f1;
            text-align: center;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            body {
                margin-top: 70px;
            }

            .navbar-container {
                padding: 0 20px;
                position: relative;
            }

            .mobile-menu-toggle {
                display: block;
            }
            
            .navbar-nav {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #2c3e50;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
                transform: translateY(-100%);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                border-top: 2px solid #34495e;
            }

            .navbar-nav.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            
            .nav-item {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .nav-link {
                text-align: center;
                margin: 0;
                padding: 15px 20px;
                border-radius: 8px;
                width: 100%;
            }

            .logout-btn {
                margin: 10px 0 0 0;
                text-align: center;
                display: block;
                width: 100%;
            }

            .main-content {
                padding: 20px 15px;
            }

            .page-header h1 {
                font-size: 2rem;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background: #34495e;
                color: #ecf0f1;
            }

            .demo-card {
                background: #2c3e50;
                border-color: #4a5568;
                color: #ecf0f1;
            }

            .page-header h1 {
                color: #ecf0f1;
            }

            .page-header p {
                color: #bdc3c7;
            }
        }

        /* Animation for slide up */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .demo-card {
            animation: slideUp 0.6s ease-out;
        }
    </style>

    <nav class="navbar">
        <div class="navbar-container">
            <a href="view_books.php" class="navbar-brand">Admin Panel</a>
            
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                ☰
            </button>
            
            <ul class="navbar-nav" id="navbarNav">
                <li class="nav-item">
                    <a href="../book/view_books.php" class="nav-link">Vıew Books</a>
                </li>
                <li class="nav-item">
                    <a href="../book/add_book.php" class="nav-link">Add Book</a>
                </li>
                <li class="nav-item">
                    <a href="../transactions/view_transaction.php" class="nav-link">Vıew Transaction</a>
                </li>
                <li class="nav-item">
                    <a href="../user/manage_users.php" class="nav-link">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a href="../logout.php" class="logout-btn" onclick="return confirm('Çıkış yapmak istediğinizden emin misiniz?')">
                        Çıkış Yap
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        function toggleMobileMenu() {
            const navbarNav = document.getElementById('navbarNav');
            navbarNav.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navbarNav = document.getElementById('navbarNav');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!navbarNav.contains(event.target) && !toggle.contains(event.target)) {
                navbarNav.classList.remove('active');
            }
        });

        // Close mobile menu when window is resized
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('navbarNav').classList.remove('active');
            }
        });
    </script>
</body>
</html>