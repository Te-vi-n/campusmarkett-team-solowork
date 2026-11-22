<?php
require __DIR__ . '/includes/functions.php';

$errors = [];
$name = '';
$email = '';
$acceptedTerms = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim((string) $_POST['name']) : '';
    $email = isset($_POST['email']) ? trim((string) $_POST['email']) : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? (string) $_POST['confirm_password'] : '';
    $acceptedTerms = isset($_POST['terms']);

    if ($name === '') {
        $errors[] = 'Name is required.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords must match.';
    }

    if (!$acceptedTerms) {
        $errors[] = 'You must accept the terms.';
    }

    unset($password, $confirmPassword);

    if (empty($errors)) {
        header('Location: welcome.php?name=' . urlencode($name));
        exit;
    }
}

$pageTitle = 'Register';
require __DIR__ . '/includes/header.php';
?>

<section class="form-section">
  <h1>Register</h1>

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

  <form id="register-form" method="post" action="register.php" novalidate>
    <div class="field">
      <label for="name">Name</label>
      <input id="name" name="name" type="text" value="<?= e($name) ?>" required>
    </div>

    <div class="field">
      <label for="email">Email</label>
      <input id="email" name="email" type="email" value="<?= e($email) ?>" required>
    </div>

    <div class="field">
      <label for="password">Password</label>
      <input id="password" name="password" type="password" required>
    </div>

    <div class="field">
      <label for="confirm_password">Confirm Password</label>
      <input id="confirm_password" name="confirm_password" type="password" required>
    </div>

    <div class="field checkbox-field">
      <input id="terms" name="terms" type="checkbox" value="1" <?= $acceptedTerms ? 'checked' : '' ?> required>
      <label for="terms">I accept the terms</label>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</section>

<?php
require __DIR__ . '/includes/footer.php';