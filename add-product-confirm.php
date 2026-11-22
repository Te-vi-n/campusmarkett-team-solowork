<?php
require __DIR__ . '/includes/functions.php';

$name = isset($_GET['name']) && trim((string) $_GET['name']) !== ''
    ? trim((string) $_GET['name'])
    : 'Untitled Product';
$price = isset($_GET['price']) && is_numeric($_GET['price']) && (float) $_GET['price'] > 0
    ? (float) $_GET['price']
    : 0;
$category = isset($_GET['category']) && trim((string) $_GET['category']) !== ''
    ? trim((string) $_GET['category'])
    : 'General';
$stock = isset($_GET['stock']) && filter_var($_GET['stock'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) !== false
    ? (int) $_GET['stock']
    : 0;

$status = getStockStatus($stock);

$pageTitle = 'Product Confirmation';
require __DIR__ . '/includes/header.php';
?>

<section class="confirm-section">
  <h1>Product Confirmation</h1>
  <article class="product-card">
    <div class="product-body">
      <div class="product-meta">
        <span><?= e($category) ?></span>
        <span class="badge <?= e($status['class']) ?>"><?= e($status['label']) ?></span>
      </div>
      <h2><?= e($name) ?></h2>
      <p class="product-price"><?= e(formatPrice($price)) ?></p>
    </div>
  </article>
  <a class="btn btn-secondary" href="add-product.php">Add Another Product</a>
</section>

<?php
require __DIR__ . '/includes/footer.php';