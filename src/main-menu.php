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
    <link rel="stylesheet" href="css/main-menu.css">
    <link rel="stylesheet" href="css/reg-avto.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Главная страница</title>
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
                    pattern="[a-zA-Zа-яА-ЯёЁ\s\-]+" title="Допустимы только буквы, пробел и дефис" required>
                <input class="form-input-areg" type="text" name="last_name" placeholder="Ваша фамилия*"
                    pattern="[a-zA-Zа-яА-ЯёЁ\s\-]+" title="Допустимы только буквы, пробел и дефис" required>
                <input class="form-input-areg" type="email" name="email" placeholder="E-mail*" required>
                <input class="form-input-areg" type="password" name="password" placeholder="Пароль*"
                    minlength="8" pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                    title="Минимум 8 символов, хотя бы одна латинская буква и одна цифра" required>
                <input class="form-input-areg" type="password" name="confirm_password" placeholder="Подтверждение пароля*" required>
                <button class="form-button-areg" type="submit">Создать аккаунт</button>
                <button class="form-button-avtoreg" id="link-btn-avto">Уже зарегистрированы? - Авторизация</button>
            </form>
        </div>

    </div>

    <div class="container-form-avto" id="modal-avto">
        <div class="block-avto">
            <h2 class="form-title-areg">Авторизация</h2>
            <form action="avto.php" method="POST">
                <input class="form-input-areg" type="email" name="email" placeholder="E-mail*" required>
                <input class="form-input-areg" type="password" name="password" placeholder="Пароль*" required>
                <button class="form-button-areg" type="submit">Авторизоваться</button>
                <button class="form-button-avtoreg" id="link-btn-reg">Нет аккаунта? - Регистрация</button>
            </form>
        </div>
    </div>

    <section id="choice">
        <div class="container-choice">
            <img src="img/products-main-menu.png" alt="Вкусности" class="choice-image">
            <div class="block-choice">
                <div class="block-title-choice">
                    <div class="title-choice">
                        <h2>Сделай выбор к новым вкусным<br>открытиям вместе со сладкоедом!</h2>
                    </div>
                </div>

                <div class="block-image-choice">
                    <div class="block-row-product">
                        <div class="block-product">
                            <div class="title-product">
                                <h3>Батончики</h3>
                            </div>
                            <img src="img/Baton.png" alt="Батончики" class="choice-product-img">
                        </div>

                        <div class="block-product">
                            <div class="title-product">
                                <h3>Вафли</h3>
                            </div>
                            <img src="img/vafli.png" alt="Вафли" class="choice-product-img">
                        </div>
                    </div>

                    <div class="block-row-product">
                        <div class="block-product">
                            <div class="title-product">
                                <h3>Маффины</h3>
                            </div>
                            <img src="img/maffin.png" alt="Маффины" class="choice-product-img">
                        </div>

                        <div class="block-product">
                            <div class="title-product">
                                <h3>Шоколад</h3>
                            </div>
                            <img src="img/Plitka.png" alt="Шоколад" class="choice-product-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about-product">
        <div class="container-about-product">
            <h2 class="title">О продукции</h2>
            <div class="block-row-about-product">
                <div class="block-text-product">
                    <p>Мы производим батончики, плитки, маффины и вафли, поэтому предлагаем вам погрузиться в атмосферу уюта
                        и наслаждения с нашими шоколадными плитками, батончиками, маффинами и вафлями. Каждое изделие приготовлено
                        с заботой и из натуральных ингредиентов — именно так рождается настоящий вкус!</p>
                    <p><br>Вкусные моменты и новые открытия — это не просто сладости, это маленькие шедевры для вашего удовольствия.</p>
                </div>
                <img src="img/about-productimg1.png" alt="Вкусности">
            </div>

            <div class="block-row-about-product">
                <img src="img/about-product-img2.png" alt="Вкусности">
                <div class="block-text-product">
                    <p>Также мы производим пончики, донаты и печенье и считаем, что это не просто сладости, а сладости, приносящие
                        настоящую заботу и уют. Всё изготовливается из натуральных ингредиентов, с авторскими рецептами,
                        вот секрет нашей вкусной магии!</p>
                    <p><br>Каждый кусочек — это маленький праздник: свежесть, хруст и тающая сладость в каждой детали.</p>
                </div>
            </div>

        </div>
    </section>

    <section id="about-company">
        <div class="container-about-company">
            <h3 class="title">О продукции</h3>
            <div class="block-row-about-company">
                <div class="block-text-company">
                    <p>Наша компания — это современная кондитерская фабрика, которая стремится создавать не просто сладости, а настоящие
                        произведения искусства, сочетая современные технологии и ручной труд, мы создаём десерты с неповторимым вкусом
                        и текстурой. Нам важно, чтобы каждый клиент почувствовал заботу и тепло в каждой нашей продукции —
                        ведь мы не просто делаем сладости, мы делаем их с любовью.</p>
                    <p><br>Мы гордимся своей философией: каждая деталь важна, каждая сладость должна вызывать улыбку и радовать ваших близких</p>
                </div>
                <img src="img/company.png" alt="Компания">
            </div>
        </div>
    </section>

    <section id="our-products-and-cooperation">
        <div class="container-our-products-and-cooperation">
            <div class="title">Наша продукция</div>
            <div class="block-strelki">
                <div class="block-strelka-slider strelka-start">
                    <img src="img/Stroke-slider-100.png" alt="Стрелка влево">
                </div>

                <div class="block-strelka-slider strelka-end">
                    <img src="img/Stroker-Slider-100-end.png" alt="Стрелка вправо">
                </div>
            </div>
            <div class="container-our-products">
                <div class="container-slider-products">
                    <div class="block-title-product">
                        <h3>Батончик с карамелью</h3>
                    </div>
                    <div class="block-img-slider">
                        <img src="img/Baton-our.png" alt="Батон">
                    </div>
                </div>

                <div class="container-slider-products">
                    <div class="block-title-product">
                        <h3>Вафля с клубникой</h3>
                    </div>
                    <div class="block-img">
                        <img src="img/vafli-our.png" alt="Вафля с клубникой">
                    </div>
                </div>

                <div class="container-slider-products">
                    <div class="block-title-product">
                        <h3>Плитка шоколада</h3>
                    </div>
                    <div class="block-img-slider">
                        <img src="img/Plitka-our.png" alt="Плитка шоколада">
                    </div>
                </div>
            </div>
            <div class="title">Мы сотрудничаем с</div>
            <div class="row-cooperation-company">
                <img src="img/Красный октябрь.png" alt="Красный октябрь">
                <img src="img/Бабаевский.png" alt="Бабаевский">
                <img src="img/РотФронт.png" alt="РотФронт">
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
    <script src="js/slider.js"></script>
    <script src="js/modal-reg-avto.js"></script>
</body>

</html>