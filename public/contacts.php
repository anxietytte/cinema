<?php
require_once __DIR__ . '/../src/bootstrap.php';
$pageTitle = 'Контакты';
$activePage = 'contacts';
$bodyClass = 'inner-page';
require ROOT_DIR . '/src/views/header.php';
?>
<div class="contacts-container">
    <div class="contacts-header">
        <h1>Контакты</h1>
        <p>Свяжитесь с нами удобным способом</p>
    </div>

    <div class="contact-grid">
        <div class="contact-card">
            <h3>Адрес</h3>
            <p>ул. Кино, 13, город Кино, 101000</p>
        </div>
        <div class="contact-card">
            <h3>Email</h3>
            <p>support@cinemabooking.com</p>
        </div>
        <div class="contact-card">
            <h3>Телефон</h3>
            <p>+7 (999) 123-45-67</p>
        </div>
    </div>

    <section class="contacts-section" style="margin-top: 2rem;">
        <h2>Режим работы</h2>
        <p>Ежедневно с 10:00 до 22:00</p>
    </section>
</div>
<?php require ROOT_DIR . '/src/views/footer.php'; ?>
