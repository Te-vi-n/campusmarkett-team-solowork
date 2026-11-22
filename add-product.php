<?php
require __DIR__ . '/includes/functions.php';
$allProducts = require __DIR__ . '/data/products.php';
$allowedCategories = getCategories($allProducts);

$errors = [];
$name = '';
$priceInput = '';
$category = '';
$stockInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim((string) $_POST['name']) : '';
    $priceInput = isset($_POST['price']) ? trim((string) $_POST['price']) : '';
    $category = isset($_POST['category']) ? trim((string) $_POST['category']) : '';
    $stockInput = isset($_POST['stock']) ? trim((string) $_POST['stock']) : '';

    if ($name === '') {
        $errors[] = 'Product name is required.';
    }

    if ($priceInput === '' || !is_numeric($priceInput) || (float) $priceInput <= 0) {
        $errors[] = 'Price must be a number greater than 0.';
    }

    if ($category === '' || !in_array($category, $allowedCategories, true)) {
        $errors[] = 'Category must be one of the theme’s real categories.';
    }

    if ($stockInput === '' || filter_var($stockInput, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $errors[] = 'Stock must be a whole number from 0 up.';
    }

    if (empty($errors)) {
        $query = http_build_query([
            'name' => $name,
            'price' => (float) $priceInput,
            'category' => $category,
            'stock' => (int) $stockInput,
        ]);
        header('Location: add-product-confirm.php?' . $query);
        exit;
    }
}

$pageTitle = 'Add Product';
require __DIR__ . '/includes/header.php';
?>

<section class="form-section">
  <h1>Add a Product</h1>

  <?php if (!empty($errors)): ?>
    <div class="error-box" role="alert">
      <h2>Please fix the following errors:</h2>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= e($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" action="add-product.php" novalidate>
    <div class="field">
      <label for="name">Product Name</label>
      <input id="name" name="name" type="text" value="<?= e($name) ?>" required>
    </div>

    <div class="field">
      <label for="price">Price</label>
      <input id="price" name="price" type="number" step="0.01" min="0.01" value="<?= e($priceInput) ?>" required>
    </div>

    <div class="field">
      <label for="category">Category</label>
      <select id="category" name="category" required>
        <option value="">Choose a category</option>
        <?php foreach ($allowedCategories as $cat): ?>
          <option value="<?= e($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
            <?= e($cat) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <label for="stock">Stock</label>
      <input id="stock" name="stock" type="number" step="1" min="0" value="<?= e($stockInput) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Create Product Preview</button>
  </form>
</section>

<?php
require __DIR__ . '/includes/footer.php';