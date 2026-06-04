<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/UserModel.php';

if (isAuth()) {
    redirect(publicUrl('profile.php'));
}

$errors = [];
$email = trim($_POST['email'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $user = findUserByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = 'Неверный email или пароль.';
    } elseif (!(bool)$user['is_active']) {
        $errors[] = 'Аккаунт отключён.';
    } else {
        loginUser($user);
        redirect(publicUrl('profile.php'));
    }
}

$pageTitle = 'Вход';
$activePage = '';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="auth-wrapper">
    <div class="auth-card">
        <h1>Вход</h1>
        <?php foreach ($errors as $error): ?>
            <div class="form-error"><?= e($error) ?></div>
        <?php endforeach; ?>
        <form method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= e($email) ?>" required>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <button class="submit-btn" type="submit">Войти</button>
        </form>
        <div class="auth-links">Нет аккаунта? <a href="<?= e(publicUrl('register.php')) ?>">Регистрация</a></div>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
