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
    <link rel="stylesheet" href="css/about-company.css">
    <link rel="stylesheet" href="css/reg-avto.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    <section id="about-company">
        <div class="title">О компании</div>
        <div class="container-about-company">
            <div class="block-about-company-text">
                <p class="text-company"><span class="attention-text">Наша компания</span> — это современная кондитерская фабрика, которая стремится 
                    создавать не просто сладости, а настоящие произведения искусства, сочетая современные технологии и ручной труд,
                    мы создаём десерты с неповторимым вкусом и текстурой. Нам важно, чтобы каждый клиент почувствовал заботу и тепло в 
                    каждой нашей продукции — ведь мы не просто делаем сладости, мы делаем их с любовью.</p>
                <p class="text-company"><br>Мы гордимся своей философией: каждая деталь важна, каждая сладость должна вызывать улыбку и радовать ваших близких</p>
            </div>
            <img src="img/about-company.png" alt="Фотография фабрики">
        </div>
        <div class="title">История компании</div>
        <div class="container-history-company">
            <div class="block-history-company-text">
                <p class="text-company"><span class="attention-text">Наша история</span> началась с мечты: мы хотели создать сладости, которые не просто вкусные, а
                     будут напоминать о вкусе всегда. Всё началось с маленькой семейной мастерской, где мы эксперементировали с рецептами и 
                     подбирали идеальное сочетание натуральных ингредиентов. Постепенно мы выросли в современную кондитерскую фабрику, 
                     сохранив в каждом изделии частичку нашей души и уникальный подход.</p>
                <p class="text-company"><br>Мы выбрали направление производства кондитерских изделий, потому что верим: сладости — это не просто лакомство,
                     а возможность сделать каждый момент чуть теплее. Мы хотим, чтобы наши продукты были неотъемлемой частью вашего праздника
                      — даже самого обычного дня!</p>
            </div>
            <img src="img/history-company.png" alt="Фотография старой фабрики">
        </div>
        <div class="title">Миссия компании</div>
        <div class="container-mission-company">
            <div class="block-mission-text">
                <p class="text-company"><span class="attention-text">Наша миссия</span> — создавать десерты, которые радуют, вдохновляют и дарят незабываемые эмоции.
                     Мы стремимся сочетать натуральные ингредиенты, мастерство и современные технологии, чтобы каждая сладость напоминала вам: счастье в простых вещах!
                      Наш основной слоган “С любовью и заботой — каждый кусочек для вас!”, так как мы трудимся, чтобы вы ощутили все те эмоции от нашей продукции.</p>
            </div>
            <div class="block-target-company">
                <p class="text-company"><span class="attention-text">Цели компании:</span></p>
                <ul class="text-company">
                    <li>Поддерживать высокое качество и безопасность каждого продукта;</li>
                    <li>Постоянно совершенствовать рецептуры и искать новые сочетания вкусов;</li>
                    <li>Развивать культуру кондитерского искусства и делиться ею с клиентами;</li>
                    <li>Создавать ассортимент, который будет радовать как детей, так и взрослых;</li>
                    <li>Быть честными и открытыми: забота о клиенте — в основе всего.</li>
                </ul>
            </div>
            <div class="target-images">
                    <img src="img/document.png" alt="Документ">
                    <img src="img/sert.png" alt="Сертификат">
                    <img src="img/Brand.png" alt="Известный бренд">
                </div>
            <div class="title">О нашей продукции</div>
            <div class="block-about-product">
                <p class="text-company"><span class="attention-text">Наша продукция</span> — это натуральные и качественные десерты: шоколадные плитки и батончики, маффины, 
                    вафли, печенье, пончики и многое другое. Мы используем только проверенные ингредиенты: настоящие какао-бобы, отборное молоко, свежее масло и муку. 
                    Благодаря этому каждый наш продукт отличается насыщенным вкусом, нежной текстурой и свежестью.</p>
            </div>
            <div class="block-advantages-product">
                <p class="text-company"><span class="attention-text">Наши преимущества:</span></p>
                <ul class="text-company">
                    <li>Натуральные ингредиенты — без компромиссов;</li>
                    <li>Ручной подход и внимание к каждой детали;</li>
                    <li>Современное оборудование — для безупречного качества;</li>
                    <li>Инновационные рецептуры — для новых вкусовых открытий;</li>
                    <li>Забота о вас: мы всегда готовы выслушать ваши пожелания и воплотить их в новых сладостя</li>
                </ul>
            </div>
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
            <div class="title">Рабочее местоположение и регионы продажи</div>
        </div>
        <div class="container-regions">
                <div class="block-regions_left block-regions">
                    <p class="text-company">Наш офис располагается по адресу г. Москва, Ул. Дымкова, к. 1, офис 11.</p>
                </div>
                <div class="block-regions_right block-regions">
                    <p class="text-company">Мы продаём продукцию в следующих странах: Россия, Беларусь, Армения, Грузия.</p>
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