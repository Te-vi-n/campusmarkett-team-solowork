<?php
$pageTitle = $pageTitle ?? 'CampusMarket';
$safeTitle = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $safeTitle ?> | CampusMarket — Campus Tech &amp; Study Gear</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="assets/js/app.js" defer></script>
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="index.php">
        <span class="brand-mark">CM</span>
        <span>CampusMarket</span>
        <small class="theme-tag">Campus Tech &amp; Study Gear</small>
      </a>
      <nav class="site-nav" aria-label="Primary Navigation">
        <a href="index.php">Home</a>
        <a href="catalog.php">Catalog</a>
        <a href="add-product.php">Add Product</a>
        <a href="register.php">Register</a>
      </nav>
    </div>
  </header>
  <main class="site-main container">