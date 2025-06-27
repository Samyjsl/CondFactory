document.addEventListener('DOMContentLoaded', function() { // Создание DOM контента и элементов к нему
    const allProducts = [ // Ключи и их значения
        {
            title: "Батончик с карамелью",
            img: "img/Baton-our.png",
            alt: "Батон"
        },
        {
            title: "Вафля с клубникой",
            img: "img/vafli-our.png",
            alt: "Вафля с клубникой"
        },
        {
            title: "Плитка шоколада",
            img: "img/Plitka-our.png",
            alt: "Плитка шоколада"
        },
        {
            title: "Маффин",
            img: "img/maffin-our.png",
            alt: "Маффин"
        },
        {
            title: "Пончик",
            img: "img/Пончик.png",
            alt: "Пончик"
        },
    ];
    
    const sliderContainer = document.querySelector('.container-our-products'); // Поиск элемента с таким названием для переменной x3
    const prevBtn = document.querySelector('.strelka-start');
    const nextBtn = document.querySelector('.strelka-end');
    let currentIndex = 0;
    
    // Функция для отображения текущих продуктов
    function showProducts() {
        const productsToShow = [];
        
        for (let i = 0; i < 3; i++) {
            const index = (currentIndex + i) % allProducts.length;
            productsToShow.push(allProducts[index]);
        }
        
        // Очистка слайдера
        sliderContainer.innerHTML = '';
        
        // Добавление изделий
        productsToShow.forEach(product => {
            const productElement = document.createElement('div');
            productElement.className = 'container-slider-products';
            productElement.innerHTML = `
                <div class="block-title-product">
                    <h3>${product.title}</h3>
                </div>
                <div class="block-img-slider">
                    <img src="${product.img}" alt="${product.alt}">
                </div>
            `;
            sliderContainer.appendChild(productElement);
        });
    }
    
    // Обработчик событий для кнопок
    prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + allProducts.length) % allProducts.length;
        showProducts();
    });
    
    nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % allProducts.length;
        showProducts();
    });
    
    // Показ слайдера
    showProducts();
});