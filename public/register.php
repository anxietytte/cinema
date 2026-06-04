<?php
require_once __DIR__ . '/../src/bootstrap.php';
require_once ROOT_DIR . '/src/models/UserModel.php';

if (isAuth()) {
    redirect(publicUrl('profile.php'));
}

$errors = [];
$old = ['name' => '', 'email' => '', 'phone' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name'] = trim($_POST['name'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['phone'] = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if ($old['name'] === '') {
        $errors[] = 'Введите имя.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Введите корректный email.';
    } elseif (emailExists($old['email'])) {
        $errors[] = 'Пользователь с таким email уже существует.';
    }
    if (mb_strlen($password) < 6) {
        $errors[] = 'Пароль должен быть не короче 6 символов.';
    }
    if ($password !== $passwordConfirm) {
        $errors[] = 'Пароли не совпадают.';
    }

    if (!$errors) {
        createUser($old['name'], $old['email'], $password, $old['phone']);
        setFlash('success', 'Регистрация выполнена. Теперь войдите в аккаунт.');
        redirect(publicUrl('login.php'));
    }
}

$pageTitle = 'Регистрация';
$activePage = '';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="auth-wrapper">
    <div class="auth-card">
        <h1>Регистрация</h1>
        <?php foreach ($errors as $error): ?>
            <div class="form-error"><?= e($error) ?></div>
        <?php endforeach; ?>
        <form method="post" id="registerForm">
            <div class="form-group">
                <label>Имя</label>
                <input type="text" name="name" value="<?= e($old['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="registerEmail" value="<?= e($old['email']) ?>" required>
                <div class="field-error" id="emailCheckMessage"></div>
            </div>
            <div class="form-group">
                <label>Телефон</label>
                <input type="text" name="phone" value="<?= e($old['phone']) ?>" placeholder="+7 (999) 123-45-67">
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Подтверждение пароля</label>
                <input type="password" name="password_confirm" required>
            </div>
            <button class="submit-btn" type="submit">Зарегистрироваться</button>
        </form>
        <div class="auth-links">Уже есть аккаунт? <a href="<?= e(publicUrl('login.php')) ?>">Войти</a></div>
    </div>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
