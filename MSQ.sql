-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: mysql-docker:3306
-- Время создания: Июн 17 2025 г., 06:55
-- Версия сервера: 8.0.42
-- Версия PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ConfectioneryFactory`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Basket`
--

CREATE TABLE `Basket` (
  `id_basket` int NOT NULL,
  `id_user` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `Feedback_Messages`
--

CREATE TABLE `Feedback_Messages` (
  `id` int NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Feedback_Messages`
--

INSERT INTO `Feedback_Messages` (`id`, `first_name`, `last_name`, `email`, `message`, `created_at`) VALUES
(3, 'Сергей', 'Шох', 'sam@gmail.com', 'Привет', '2025-06-14 21:23:35'),
(4, 'Сергей', 'Недосекин', 'serg@gmail.com', 'Ваша продукция класс, а особенно пончик, он мне прям понравился.', '2025-06-15 12:50:19'),
(5, 'Сергей', 'Шох', 'sam@gmail.com', '123', '2025-06-17 05:57:04');

-- --------------------------------------------------------

--
-- Структура таблицы `Ingredients`
--

CREATE TABLE `Ingredients` (
  `id_ingredient` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Ingredients`
--

INSERT INTO `Ingredients` (`id_ingredient`, `name`, `type`) VALUES
(1, 'Клубника', 'Фрукт'),
(2, 'Мука пшеничная', 'Основа'),
(3, 'Шоколад', 'Какао'),
(4, 'Карамель', 'Топпинг'),
(5, 'Глазурь', 'Украшение');

-- --------------------------------------------------------

--
-- Структура таблицы `Orders`
--

CREATE TABLE `Orders` (
  `id_order` int NOT NULL,
  `id_user` int NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `entrance` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `floor` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apartment` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `intercom` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `total_price` decimal(10,0) NOT NULL,
  `id_status` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Orders`
--

INSERT INTO `Orders` (`id_order`, `id_user`, `address`, `entrance`, `floor`, `apartment`, `intercom`, `comment`, `total_price`, `id_status`, `created_at`, `updated_at`) VALUES
(13, 1, 'Какое-то', '12', '12', '12', '12', '121212', 940, 1, '2025-06-14 21:09:40', '2025-06-14 21:09:40'),
(14, 8, 'Какое-то', '1222', '222', '2222', '2222', 'я хочу покушать а именно пожрать', 2650, 2, '2025-06-15 12:47:49', '2025-06-15 12:48:36'),
(15, 8, 'Ул.Дом12', '122', '122', '122', '122', 'Приветик, маффин зачёт', 1280, 2, '2025-06-17 05:35:08', '2025-06-17 05:35:31'),
(16, 9, 'Ул.Дом15', '12', '156', '1256', '1256', 'hehe', 3020, 1, '2025-06-17 05:59:41', '2025-06-17 05:59:41');

-- --------------------------------------------------------

--
-- Структура таблицы `Order_Items`
--

CREATE TABLE `Order_Items` (
  `id_order_item` int NOT NULL,
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Order_Items`
--

INSERT INTO `Order_Items` (`id_order_item`, `id_order`, `id_product`, `quantity`, `price`) VALUES
(14, 13, 1, 2, 310),
(15, 13, 2, 1, 320),
(16, 14, 1, 3, 310),
(17, 14, 2, 3, 320),
(18, 14, 5, 2, 380),
(19, 15, 2, 4, 320),
(20, 16, 1, 4, 310),
(21, 16, 2, 2, 320),
(22, 16, 5, 3, 380),
(23, 14, 4, 14, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `Products`
--

CREATE TABLE `Products` (
  `id_product` int NOT NULL,
  `name` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_type_product` int NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `number_of_grams` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `constituent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Products`
--

INSERT INTO `Products` (`id_product`, `name`, `id_type_product`, `price`, `number_of_grams`, `description`, `constituent`, `image`, `stock_quantity`) VALUES
(1, 'Вафля с клубникой', 1, 310, 210, 'Лёгкая и воздушная вафля, дополненная свежей клубникой. Натуральный состав и богатый вкус создают настоящую симфонию сладких впечатлений. Отличный выбор для лёгкого десерта или перекуса!', 'Мука пшеничная, сахар, яйца, молоко, сливочное масло, свежая клубника, ваниль, разрыхлитель теста, натуральный ароматизатор.', 'img-products/Вафля с клубникой.png', 15),
(2, 'Шоколадный маффин', 5, 320, 230, 'Пышный маффин с насыщенным вкусом тёмного шоколада. Идеальный десерт для тех, кто любит богатый и глубокий шоколадный аромат.', 'Мука пшеничная, какао-порошок, сахар, яйца, молоко, сливочное масло, разрыхлитель, шоколадная крошка.', 'img-products/Шоколадный маффин.png', 5),
(3, 'Плитка шоколада', 3, 340, 100, 'Классика, проверенная временем. Плитка нежного молочного шоколада, тающего на языке. Наслаждение с первого кусочка!', 'Какао-масло, молоко сухое, сахар, какао тертое, лецитин (эмульгатор), натуральный ванилин.', 'img-products/Плитка шоколада.png', 2),
(4, 'Батончик с карамелью', 2, 360, 130, 'Хрустящая основа, тянущаяся карамель и шоколадное покрытие — идеальное лакомство для тех, кто любит баланс сладкого и сытного.', 'Кукурузные хлопья, карамель, молочный шоколад, сливки, сахар, масло, соевый лецитин, соль.', 'img-products/Батончик с карамелью.png', 20),
(5, 'Розовый пончик', 4, 380, 140, 'Мягкий пончик с клубничной глазурью и яркой посыпкой. Весёлый десерт, который поднимает настроение с первого взгляда!', 'Мука, яйца, сахар, дрожжи, молоко, сливочное масло, клубничная глазурь, пищевые красители, посыпка.', 'img-products/Розовый пончик.png', 1),
(6, 'Печенье с шоколадом', 6, 320, 230, 'Хрустящее снаружи и мягкое внутри печенье с тающей шоколадной крошкой. Лучшее сочетание вкуса и уюта.', 'Мука, сливочное масло, сахар, яйца, ваниль, сода, соль, шоколадная крошка.', 'img-products/Печенье с шоколадом.png', 0),
(9, 'Вафля с клубникой', 1, 123, 123, '123', '123', '123', 123);

-- --------------------------------------------------------

--
-- Структура таблицы `Product_Ingredients`
--

CREATE TABLE `Product_Ingredients` (
  `id_product_ingredients` int NOT NULL,
  `id_product` int NOT NULL,
  `id_ingredient` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Product_Ingredients`
--

INSERT INTO `Product_Ingredients` (`id_product_ingredients`, `id_product`, `id_ingredient`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 2, 3),
(5, 3, 3),
(6, 4, 4),
(7, 5, 5),
(8, 6, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `Status`
--

CREATE TABLE `Status` (
  `id_status` int NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Status`
--

INSERT INTO `Status` (`id_status`, `name`) VALUES
(1, 'Фасовка'),
(2, 'Отменён'),
(3, 'Выполнен'),
(4, 'У курьера');

-- --------------------------------------------------------

--
-- Структура таблицы `Suppliers`
--

CREATE TABLE `Suppliers` (
  `id_supplier` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Suppliers`
--

INSERT INTO `Suppliers` (`id_supplier`, `name`) VALUES
(1, 'Сладкий Мир'),
(2, 'Вкусные Поставки'),
(3, 'ChocoTrade');

-- --------------------------------------------------------

--
-- Структура таблицы `Supplier_Products`
--

CREATE TABLE `Supplier_Products` (
  `id_supplier_product` int NOT NULL,
  `id_supplier` int NOT NULL,
  `id_product` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Supplier_Products`
--

INSERT INTO `Supplier_Products` (`id_supplier_product`, `id_supplier`, `id_product`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 2),
(4, 2, 5),
(5, 3, 4),
(6, 3, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `Type_Product`
--

CREATE TABLE `Type_Product` (
  `id_type_product` int NOT NULL,
  `name` varchar(110) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Type_Product`
--

INSERT INTO `Type_Product` (`id_type_product`, `name`) VALUES
(1, 'Вафля'),
(2, 'Батончик'),
(3, 'Шоколад'),
(4, 'Пончик'),
(5, 'Маффин'),
(6, 'Печенье');

-- --------------------------------------------------------

--
-- Структура таблицы `Type_User`
--

CREATE TABLE `Type_User` (
  `id_type_user` int NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Type_User`
--

INSERT INTO `Type_User` (`id_type_user`, `name`) VALUES
(1, 'Пользователь'),
(2, 'Админ');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id_user` int NOT NULL,
  `name` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_type_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id_user`, `name`, `surname`, `email`, `password`, `id_type_user`) VALUES
(1, 'Максим', 'Антонов', 'sam@gmail.com', 'qwerty1234', 2),
(2, 'Сергей', 'Дрожев', 'adminDrozh-@gmail.com', 'qwerty1234', 2),
(4, 'Сергей', 'Дрож', 'saw2018_ant@mail.ru', '1234', 1),
(8, 'Сергей', 'Недосекин', 'serg@gmail.com', 'qwerty1234', 1),
(9, 'Ангелина', 'Герлах', 'limur@gmail.com', 'q12345678', 1);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view1`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view1` (
`id` int
,`Категория изделия` varchar(183)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view2`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view2` (
`id` int
,`Клиент` varchar(369)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view3`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view3` (
`id` int
,`Информация о поставщике` varchar(239)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view4`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view4` (
`id` int
,`Оставшиеся количество` varchar(104)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view5`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view5` (
`id` int
,`Информация о заказе` varchar(40)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view6`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view6` (
`id` int
,`Поставщик Ингредиент` varchar(184)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view7`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view7` (
`id` int
,`Статус заказа` varchar(99)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view8`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view8` (
`id` int
,`Информация о заказе` varchar(192)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view9`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view9` (
`id` int
,`product_name` varchar(70)
,`Всего продано` decimal(32,0)
,`По какой` timestamp
,`С какого` timestamp
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view10`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view10` (
`id` int
,`Количество изделий определенной категории` varchar(207)
);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Basket`
--
ALTER TABLE `Basket`
  ADD PRIMARY KEY (`id_basket`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `Feedback_Messages`
--
ALTER TABLE `Feedback_Messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Ingredients`
--
ALTER TABLE `Ingredients`
  ADD PRIMARY KEY (`id_ingredient`);

--
-- Индексы таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_status` (`id_status`);

--
-- Индексы таблицы `Order_Items`
--
ALTER TABLE `Order_Items`
  ADD PRIMARY KEY (`id_order_item`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_type_product` (`id_type_product`);

--
-- Индексы таблицы `Product_Ingredients`
--
ALTER TABLE `Product_Ingredients`
  ADD PRIMARY KEY (`id_product_ingredients`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_ingredient` (`id_ingredient`);

--
-- Индексы таблицы `Status`
--
ALTER TABLE `Status`
  ADD PRIMARY KEY (`id_status`);

--
-- Индексы таблицы `Suppliers`
--
ALTER TABLE `Suppliers`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Индексы таблицы `Supplier_Products`
--
ALTER TABLE `Supplier_Products`
  ADD PRIMARY KEY (`id_supplier_product`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_product` (`id_product`);

--
-- Индексы таблицы `Type_Product`
--
ALTER TABLE `Type_Product`
  ADD PRIMARY KEY (`id_type_product`);

--
-- Индексы таблицы `Type_User`
--
ALTER TABLE `Type_User`
  ADD PRIMARY KEY (`id_type_user`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_type_user` (`id_type_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Basket`
--
ALTER TABLE `Basket`
  MODIFY `id_basket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `Feedback_Messages`
--
ALTER TABLE `Feedback_Messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `Ingredients`
--
ALTER TABLE `Ingredients`
  MODIFY `id_ingredient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `Order_Items`
--
ALTER TABLE `Order_Items`
  MODIFY `id_order_item` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `Products`
--
ALTER TABLE `Products`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `Product_Ingredients`
--
ALTER TABLE `Product_Ingredients`
  MODIFY `id_product_ingredients` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `Status`
--
ALTER TABLE `Status`
  MODIFY `id_status` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `Suppliers`
--
ALTER TABLE `Suppliers`
  MODIFY `id_supplier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `Supplier_Products`
--
ALTER TABLE `Supplier_Products`
  MODIFY `id_supplier_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `Type_Product`
--
ALTER TABLE `Type_Product`
  MODIFY `id_type_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `Type_User`
--
ALTER TABLE `Type_User`
  MODIFY `id_type_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- --------------------------------------------------------

--
-- Структура для представления `view1`
--
DROP TABLE IF EXISTS `view1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view1`  AS SELECT `P`.`id_product` AS `id`, concat(`P`.`name`,' - ',`TP`.`name`) AS `Категория изделия` FROM (`Products` `P` join `Type_Product` `TP` on((`P`.`id_type_product` = `TP`.`id_type_product`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `view2`
--
DROP TABLE IF EXISTS `view2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view2`  AS SELECT `O`.`id_order` AS `id`, concat(`U`.`name`,' ',`U`.`surname`,' - ',`O`.`address`) AS `Клиент` FROM (`Orders` `O` join `Users` `U` on((`O`.`id_user` = `U`.`id_user`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `view3`
--
DROP TABLE IF EXISTS `view3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view3`  AS SELECT DISTINCT `S`.`id_supplier` AS `id`, concat(`S`.`name`,' - поставляет продукт с ингредиентом "',`I`.`name`,'"') AS `Информация о поставщике` FROM ((((`Suppliers` `S` join `Supplier_Products` `SP` on((`S`.`id_supplier` = `SP`.`id_supplier`))) join `Products` `P` on((`SP`.`id_product` = `P`.`id_product`))) join `Product_Ingredients` `PI` on((`P`.`id_product` = `PI`.`id_product`))) join `Ingredients` `I` on((`PI`.`id_ingredient` = `I`.`id_ingredient`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `view4`
--
DROP TABLE IF EXISTS `view4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view4`  AS SELECT `Products`.`id_product` AS `id`, concat(`Products`.`name`,' - осталось на складе: ',`Products`.`stock_quantity`) AS `Оставшиеся количество` FROM `Products` WHERE (`Products`.`stock_quantity` < 10) ;

-- --------------------------------------------------------

--
-- Структура для представления `view5`
--
DROP TABLE IF EXISTS `view5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view5`  AS SELECT `Orders`.`id_order` AS `id`, concat('Заказ от ',cast(`Orders`.`created_at` as date),' на сумму ',`Orders`.`total_price`) AS `Информация о заказе` FROM `Orders` ;

-- --------------------------------------------------------

--
-- Структура для представления `view6`
--
DROP TABLE IF EXISTS `view6`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view6`  AS SELECT `S`.`id_supplier` AS `id`, concat(`S`.`name`,' - поставляет ',`P`.`name`) AS `Поставщик Ингредиент` FROM ((`Suppliers` `S` join `Supplier_Products` `SP` on((`S`.`id_supplier` = `SP`.`id_supplier`))) join `Products` `P` on((`SP`.`id_product` = `P`.`id_product`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `view7`
--
DROP TABLE IF EXISTS `view7`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view7`  AS SELECT `O`.`id_order` AS `id`, concat('Статус: ',`S`.`name`,' - заказ #',`O`.`id_order`) AS `Статус заказа` FROM (`Orders` `O` join `Status` `S` on((`O`.`id_status` = `S`.`id_status`))) ;

-- --------------------------------------------------------

--
-- Структура для представления `view8`
--
DROP TABLE IF EXISTS `view8`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view8`  AS SELECT `O`.`id_order` AS `id`, concat(`U`.`name`,' ',`U`.`surname`,' - заказал ',`P`.`name`) AS `Информация о заказе` FROM (((`Orders` `O` join `Users` `U` on((`O`.`id_user` = `U`.`id_user`))) join `Order_Items` `OI` on((`O`.`id_order` = `OI`.`id_order`))) join `Products` `P` on((`OI`.`id_product` = `P`.`id_product`))) WHERE (`U`.`id_user` = 1) ;

-- --------------------------------------------------------

--
-- Структура для представления `view9`
--
DROP TABLE IF EXISTS `view9`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view9`  AS SELECT `P`.`id_product` AS `id`, `P`.`name` AS `product_name`, sum(`OI`.`quantity`) AS `Всего продано`, min(`O`.`created_at`) AS `С какого`, max(`O`.`created_at`) AS `По какой` FROM ((`Order_Items` `OI` join `Orders` `O` on((`OI`.`id_order` = `O`.`id_order`))) join `Products` `P` on((`OI`.`id_product` = `P`.`id_product`))) WHERE (`O`.`created_at` between '2025-06-01' and '2025-06-30') GROUP BY `P`.`id_product`, `P`.`name` ;

-- --------------------------------------------------------

--
-- Структура для представления `view10`
--
DROP TABLE IF EXISTS `view10`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view10`  AS SELECT `P`.`id_product` AS `id`, concat(`P`.`name`,' - ',`TP`.`name`,', на складе: ',`P`.`stock_quantity`) AS `Количество изделий определенной категории` FROM (`Products` `P` join `Type_Product` `TP` on((`P`.`id_type_product` = `TP`.`id_type_product`))) WHERE (`P`.`stock_quantity` < 10) ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Basket`
--
ALTER TABLE `Basket`
  ADD CONSTRAINT `Basket_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `Basket_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `Products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id_user`),
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `Status` (`id_status`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `Order_Items`
--
ALTER TABLE `Order_Items`
  ADD CONSTRAINT `Order_Items_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `Orders` (`id_order`),
  ADD CONSTRAINT `Order_Items_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `Products` (`id_product`);

--
-- Ограничения внешнего ключа таблицы `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`id_type_product`) REFERENCES `Type_Product` (`id_type_product`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `Product_Ingredients`
--
ALTER TABLE `Product_Ingredients`
  ADD CONSTRAINT `Product_Ingredients_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `Products` (`id_product`) ON DELETE CASCADE,
  ADD CONSTRAINT `Product_Ingredients_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `Ingredients` (`id_ingredient`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Supplier_Products`
--
ALTER TABLE `Supplier_Products`
  ADD CONSTRAINT `Supplier_Products_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `Suppliers` (`id_supplier`) ON DELETE CASCADE,
  ADD CONSTRAINT `Supplier_Products_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `Products` (`id_product`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`id_type_user`) REFERENCES `Type_User` (`id_type_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
