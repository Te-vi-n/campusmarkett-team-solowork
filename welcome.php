<?php
require __DIR__ . '/includes/functions.php';

$rawName = isset($_GET['name']) ? trim((string) $_GET['name']) : 'Student';
if ($rawName === '') {
    $rawName = 'Student';
}
$nameParts = preg_split('/\s+/', $rawName);
$firstName = $nameParts[0] ?? 'Student';

$pageTitle = 'Welcome';
require __DIR__ . '/includes/header.php';
?>

<section class="welcome-section">
  <h1>Welcome, <?= e($firstName) ?>!</h1>
  <p>Registered name: <?= e($rawName) ?></p>
  <a class="btn btn-primary" href="catalog.php">Go to Catalog</a>
</section>

<?php
require __DIR__ . '/includes/footer.php';