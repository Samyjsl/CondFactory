<?php
session_start();

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
    header('Location: /admin/main-menu.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="icon" sizes="16x16" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/contacts.css">
    <link rel="stylesheet" href="css/reg-avto.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>О компании</title>
</head>
<body>
    <header>
        <div class="left-header">
            <a href="main-menu.php" class="header-logo">
                <img src="img/logo.svg" alt="Логотип" class="header-image-logo">
            </a>

            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="product-catalog.php" class="header-text">Каталог продукции</a></li>
                    <li><a href="about-company.php" class="header-text">О компании</a></li>
                    <li><a href="contacts.php" class="header-text">Контакты</a></li>
                </ul>
            </nav>
        </div>

        <div class="right-header">
            <a href="orders.php" class="header-link">
                <div class="block-header-text-image">
                    <img src="img/box.svg" alt="Иконка заказов" class="header-image">
                    <span class="header-text">Заказы</span>
                </div>
            </a>

            <a href="basket.php" class="header-link">
                <div class="block-header-text-image">
                    <img src="img/shopping-cart.svg" alt="Иконка корзины" class="header-image">
                    <span class="header-text">Корзина</span>
                </div>
            </a>
        </div>
    </header>

    <div class="container-form-reg" id="modal-register">
        <div class="block-reg">
            <h2 class="form-title-areg">Регистрация</h2>
            <form action="reg.php" method="POST" id="reg-form">
                <input class="form-input-areg" type="text" name="first_name" placeholder="Ваше имя*"
                    pattern="[a-zA-Zа-яА-ЯёЁ\s\-]+" title="Допустимы только буквы, пробел и дефис" required />
                <input class="form-input-areg" type="text" name="last_name" placeholder="Ваша фамилия*"
                    pattern="[a-zA-Zа-яА-ЯёЁ\s\-]+" title="Допустимы только буквы, пробел и дефис" required />
                <input class="form-input-areg" type="email" name="email" placeholder="E-mail*" required />
                <input class="form-input-areg" type="password" name="password" placeholder="Пароль*"
                    minlength="8" pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                    title="Минимум 8 символов, хотя бы одна латинская буква и одна цифра" required />
                <input class="form-input-areg" type="password" name="confirm_password" placeholder="Подтверждение пароля*" required />
                <button class="form-button-areg" type="submit">Создать аккаунт</button>
                <button class="form-button-avtoreg" id="link-btn-avto">Уже зарегистрированы? - Авторизация</button>
            </form>
        </div>
    </div>

    <div class="container-form-avto" id="modal-avto">
        <div class="block-avto">
            <h2 class="form-title-areg">Авторизация</h2>
            <form action="avto.php" method="POST">
                <input class="form-input-areg" type="email" name="email" placeholder="E-mail*" required />
                <input class="form-input-areg" type="password" name="password" placeholder="Пароль*" required />
                <button class="form-button-areg" type="submit">Авторизоваться</button>
                <button class="form-button-avtoreg" id="link-btn-reg">Нет аккаунта? - Регистрация</button>
            </form>
        </div>
    </div>

    <section id="contacts">
        <div class="title">Контакты</div>
        <div class="container-form-links">
            <div class="container-title-contacts-links">
                <div class="attention-title">Ссылки и контакты</div>
                <div class="container-contacts">
                    <div class="container-links">
                        <div class="block-links">
                            <p class="text-contacts">Мы располагаемся по адресу: <span class="attention-text"><br>г. Москва, Ул. Дымкова, к. 1, офис 11.</span></p>
                            <p class="text-contacts"><br>Наша электронная почта: <span class="attention-text"><br>SladkoedKIZ@gmail.com</span></p>
                            <p class="text-contacts"><br>Наш рабочий телефон: <span class="attention-text"><br>8-800-450-21-21</span></p>
                            <p class="text-contacts"><br>Также вы можете посетить наши социальные сети:</p>
                        </div>
                        <div class="container-social-media">
                            <a href="#"><img src="img/ok.png" alt="ОК"></a>
                            <a href="#"><img src="img/vk.png" alt="ВК"></a>
                            <a href="#"><img src="img/ru.png" alt="Рутуб"></a>
                            <a href="#"><img src="img/youtube.png" alt="Ютуб"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-form">
                <div class="attention-title">Форма обратной связи</div>
                  <div class="form-container">
                    <h2 class="form-title">Задать вопрос или предложить</h2>
                    <form id="contact-form">
                        <input class="form-input" type="text" name="first_name" placeholder="Ваше имя*" required />
                        <input class="form-input" type="text" name="last_name" placeholder="Ваша фамилия*" required />
                        <input class="form-input" type="email" name="email" placeholder="E-mail*" required />
                        <textarea class="form-textarea" name="message" placeholder="Задайте вопрос или предложите*" required></textarea>
                        <button class="form-button" type="submit">Отправить</button>
                    </form>
                </div>
            </div>
        </div> 
    </section>
    <footer>
        <div class="container-logo-nav-footer">
            <a href="main-menu.php"><img src="img/ЛоготипФулл.png" alt="Сладкоед"></a>
            <div class="block-nav-footer">
                <a href="product-catalog.php">Каталог продукции</a>
                <a href="about-company.php">О компании</a>
                <a href="contacts.php">Контакты</a>
            </div>
        </div>
        <div class="address-footer">
            <h3>Россия, г. Москва,<br>Ул. Дымкова, к.1, офис 11.</h3>
        </div>
        <div class="contacts-footer">
            <div class="block-number-footer">
                <h2>8-800-450-21-21</h2>
            </div>
            <div class="block-number-footer-text">
                <h3>Горячая линия, звонок бесплатный из<br>любого региона России</h3>
            </div>
        </div>
    </footer>
    <script src="js/modal-reg-avto.js"></script>
    <script src="js/form-message.js"></script>
</body>
</html>