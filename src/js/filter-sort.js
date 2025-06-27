document.addEventListener("DOMContentLoaded", function () {
    const sortBtn = document.getElementById("sort-price");
    const filterForm = document.getElementById("product-filter-form");

    let currentOrder = "asc";

    function loadProducts() {
        const formData = new FormData();

        const checkedBoxes = filterForm.querySelectorAll('input[name="category[]"]:checked');
        checkedBoxes.forEach(cb => formData.append('category[]', cb.value));

        formData.append('order', currentOrder);

        fetch("php-backend/filter-sort-products.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            document.querySelector(".container-product").innerHTML = html;
        });
    }
    loadProducts();

    sortBtn.addEventListener("click", function () {
        currentOrder = currentOrder === "asc" ? "desc" : "asc";
        this.dataset.order = currentOrder;
        this.textContent = currentOrder === "asc" ? "сначала дешевые↑" : "сначала дорогие↓";

        loadProducts();
    });

    filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        loadProducts();
    });
});
