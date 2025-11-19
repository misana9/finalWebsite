<?php
$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'profile', 'messages', 'products']; // list your pages
include("database/database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/dashboard.css">
    <link rel="stylesheet" href="assets/CSS/styles.css">
    <link rel="stylesheet" href="assets/CSS/header.css">
    <link rel="stylesheet" href="assets/CSS/products.css">
    <script src="assets/javascript/product.js" defer> </script>
</head>
<body>

<div id="container">
    <?php include "layout/dashboard.php"; ?> 
    <?php include "layout/header.php"; ?>

    <div id="content">
        <?php
        if (in_array($page, $allowed_pages)) {
            include "pages/$page.php";
        } else {
            echo "<h1>Page not found</h1>";
        }
        ?>
    </div>
</div>

</body>
</html>
