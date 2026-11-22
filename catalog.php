<?php
require __DIR__ . '/includes/functions.php';
$allProducts = require __DIR__ . '/data/products.php';
$categories = getCategories($allProducts);

$q = isset($_GET['q']) ? trim((string) $_GET['q']) : '';
$selectedCategory = isset($_GET['category']) ? trim((string) $_GET['category']) : '';

if ($selectedCategory !== '' && !in_array($selectedCategory, $categories, true)) {
    $selectedCategory = '';
}

$filteredProducts = [];
$qLower = mb_strtolower($q, 'UTF-8');

foreach ($allProducts as $product) {
    $matchesCategory = ($selectedCategory === '' || $product['category'] === $selectedCategory);
    $haystack = mb_strtolower(
        $product['name'] . ' ' . $product['description'] . ' ' . $product['category'] . ' ' . $product['compatibility'],
        'UTF-8'
    );
    $matchesQuery = ($qLower === '' || mb_strpos($haystack, $qLower) !== false);

    if ($matchesCategory && $matchesQuery) {
        $filteredProducts[] = $product;
    }
}

$pageTitle = 'Catalog';
require __DIR__ . '/includes/header.php';
?>

<section class="catalog-header">
  <h1>Catalog</h1>

  <form class="search-form" method="get" action="catalog.php">
    <label for="q">Search</label>
    <input id="q" type="search" name="q" value="<?= e($q) ?>" placeholder="Search products...">

    <label for="category">Category</label>
    <select id="category" name="category">
      <option value="">All Categories</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= e($cat) ?>" <?= $selectedCategory === $cat ? 'selected' : '' ?>>
          <?= e($cat) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="catalog.php" class="btn btn-secondary">Clear</a>
  </form>

  <p class="match-count">
    <?= count($filteredProducts) ?> matching product<?= count($filteredProducts) === 1 ? '' : 's' ?>
    <?php if ($q !== ''): ?> for &ldquo;<?= e($q) ?>&rdquo;<?php endif; ?>
    <?php if ($selectedCategory !== ''): ?> in <?= e($selectedCategory) ?><?php endif; ?>.
  </p>
</section>

<?php if (empty($filteredProducts)): ?>
  <p class="empty-message">No products match your search or category filter.</p>
<?php else: ?>
  <section class="product-grid">
    <?php foreach ($filteredProducts as $product): ?>
      <?php $status = getStockStatus((int) $product['stock']); ?>
      <article class="product-card">
        <img
          src="<?= e($product['image']) ?>"
          alt="<?= e($product['name']) ?> in <?= e($product['category']) ?>"
          class="product-image"
        >
        <div class="product-body">
          <div class="product-meta">
            <span><?= e($product['category']) ?></span>
            <span class="badge <?= e($status['class']) ?>"><?= e($status['label']) ?></span>
          </div>
          <h2><?= e($product['name']) ?></h2>
          <p><?= e($product['description']) ?></p>
          <p><strong>Compatibility:</strong> <?= e($product['compatibility']) ?></p>
          <p class="product-price"><?= e(formatPrice($product['price'])) ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  </section>
<?php endif; ?>

<?php
require __DIR__ . '/includes/footer.php';