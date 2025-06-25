<?php
session_start();
require_once 'config/database.php';

$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TraceIt - Product & Environmental Insight</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <i class="fas fa-leaf"></i>
                <h1>TraceIt</h1>
            </div>
            <nav class="nav">
                <a href="index.php" class="nav-link">Dashboard</a>
                <a href="index.php?page=scan" class="nav-link">Scan Product</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <?php
        switch($page) {
            case 'search':
                include 'pages/search_result.php';
                break;
            case 'category':
                include 'pages/category.php';
                break;
            case 'scan':
                include 'pages/scan.php';
                break;
            default:
                include 'pages/dashboard.php';
                break;
        }
        ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 TraceIt. Understanding products for a better world.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>