// Обработка добавления продукта
document.getElementById('form-add-product').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'product');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Изделие успешно добавлено");
        form.reset();
        document.getElementById('modal-products').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => alert("Ошибка запроса"));
});

// Обработка добавления пользователя
document.getElementById('form-add-user').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'user');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Пользователь успешно добавлен");
        form.reset();
      } else {
        alert(data.message || "Ошибка добавления пользователя");
      }
    })
    .catch(() => alert("Ошибка запроса"));
});

// Обработка добавления заказа
document.getElementById('form-add-order').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'order');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Заказ успешно добавлен");
        form.reset();
      } else {
        alert(data.message || "Ошибка добавления заказа");
      }
    })
    .catch(() => alert("Ошибка запроса"));
});

document.getElementById('form-add-order-item').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'order_item');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Товар в заказ успешно добавлен");
        form.reset();
        document.getElementById('modal-order_items').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => alert("Ошибка запроса"));
});

document.getElementById('form-add-basket').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'basket');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Товар успешно добавлен в корзину");
        form.reset();
        document.getElementById('modal-basket').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => {
      alert("Ошибка запроса");
    });
});

document.getElementById('form-add-status').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'status');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Статус успешно добавлен");
        form.reset();
        document.getElementById('modal-status').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => {
      alert("Ошибка запроса");
    });
});

document.getElementById('form-add-feedback').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'feedback');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Сообщение успешно добавлено");
        form.reset();
        document.getElementById('modal-feedback').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => {
      alert("Ошибка запроса");
    });
});

document.getElementById('form-add-ingredients').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'ingredient');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Ингредиент успешно добавлен");
        form.reset();
        document.getElementById('modal-ingredients').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => {
      alert("Ошибка запроса");
    });
});



// Автоматическая загрузка пользователей и товаров
document.addEventListener('DOMContentLoaded', () => {
  fetch('php-backend/get-atrib.php?type=orders_products')
    .then(res => res.json())
    .then(data => {
      const userSelect = document.getElementById('id_user_basket');
      const productSelect = document.getElementById('id_product_basket');

      fetch('php-backend/get-atrib.php?type=users')
        .then(res => res.json())
        .then(users => {
          users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id_user;
            option.textContent = `${user.name} ${user.surname}`;
            userSelect.appendChild(option);
          });
        });

      data.products.forEach(product => {
        const option = document.createElement('option');
        option.value = product.id_product;
        option.textContent = product.name;
        productSelect.appendChild(option);
      });
    })
    .catch(err => console.error("Ошибка загрузки данных корзины:", err));
});

document.getElementById('form-add-product-ingredients').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'product_ingredient');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Состав успешно добавлен");
        form.reset();
        document.getElementById('modal-product_ingredients').style.display = 'none';
      } else {
        alert(data.message || "Ошибка добавления");
      }
    })
    .catch(() => {
      alert("Ошибка запроса");
    });
});

document.getElementById('form-add-type_user').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'type_user');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Тип пользователя добавлен');
        form.reset();
        document.getElementById('modal-type_user').style.display = 'none';
      } else {
        alert(data.message || 'Ошибка добавления');
      }
    })
    .catch(() => {
      alert('Ошибка запроса');
    });
});

document.getElementById('form-add-suppliers').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'suppliers');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Поставщик добавлен');
        form.reset();
        document.getElementById('modal-suppliers').style.display = 'none';
      } else {
        alert(data.message || 'Ошибка добавления');
      }
    })
    .catch(() => alert('Ошибка запроса'));
});


document.getElementById('form-add-supplier_products').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  formData.append('type', 'supplier_products');

  fetch('php-backend/add-tables.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert('Изделие добавлено поставщику');
        form.reset();
        document.getElementById('modal-supplier_products').style.display = 'none';
      } else {
        alert(data.message || 'Ошибка добавления');
      }
    })
    .catch(() => alert('Ошибка запроса'));
});


document.addEventListener('DOMContentLoaded', () => {
  const userSelect = document.getElementById('id_user');
  const statusSelect = document.getElementById('id_status');

  // Загрузка пользователей
  fetch('php-backend/get-atrib.php?type=users')
    .then(res => res.json())
    .then(users => {
      users.forEach(user => {
        const option = document.createElement('option');
        option.value = user.id_user;
        option.textContent = `${user.name} ${user.surname}`;
        userSelect?.appendChild(option);
      });
    });

  fetch('php-backend/get-atrib.php?type=orders_products')
    .then(res => res.json())
    .then(data => {
      const orderSelect = document.getElementById('id_order');
      const productSelect = document.getElementById('id_product');

      data.orders.forEach(order => {
        const option = document.createElement('option');
        option.value = order.id_order;
        option.textContent = `Заказ №${order.id_order}`;
        orderSelect?.appendChild(option);
      });

      data.products.forEach(product => {
        const option = document.createElement('option');
        option.value = product.id_product;
        option.textContent = product.name;
        productSelect?.appendChild(option);
      });
    });

  fetch('php-backend/get-atrib.php?type=statuses')
    .then(res => res.json())
    .then(statuses => {
      statuses.forEach(status => {
        const option = document.createElement('option');
        option.value = status.id_status;
        option.textContent = status.name;
        statusSelect?.appendChild(option);
      });
    });

  fetch('php-backend/get-atrib.php?type=products')
    .then(res => res.json())
    .then(products => {
      const productSelect = document.getElementById('id_product_pi');
      if (productSelect) {
        productSelect.innerHTML = '<option value="">Выберите товар</option>';
        products.forEach(p => {
          const option = document.createElement('option');
          option.value = p.id_product;
          option.textContent = p.name;
          productSelect.appendChild(option);
        });
      }
    });

  fetch('php-backend/get-atrib.php?type=type_user')
    .then(response => response.json())
    .then(data => {
      const typeUserSelect = document.getElementById('id_type_user');
      if (!typeUserSelect) return;
      data.forEach(type => {
        const option = document.createElement('option');
        option.value = type.id_type_user;
        option.textContent = type.name;
        typeUserSelect.appendChild(option);
      });
    });

  fetch('php-backend/get-atrib.php?type=suppliers')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('id_supplier');
      data.forEach(supplier => {
        const option = document.createElement('option');
        option.value = supplier.id_supplier;
        option.textContent = supplier.name;
        select.appendChild(option);
      });
    });

  fetch('php-backend/get-atrib.php?type=products')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('id_product_supplier');
      data.forEach(product => {
        const option = document.createElement('option');
        option.value = product.id_product;
        option.textContent = product.name;
        select.appendChild(option);
      });
    });

  fetch('php-backend/get-atrib.php?type=ingredients')
    .then(res => res.json())
    .then(ingredients => {
      const ingredientSelect = document.getElementById('id_ingredient_pi');
      if (ingredientSelect) {
        ingredientSelect.innerHTML = '<option value="">Выберите ингредиент</option>';
        ingredients.forEach(i => {
          const option = document.createElement('option');
          option.value = i.id_ingredient;
          option.textContent = i.name;
          ingredientSelect.appendChild(option);
        });
      }
    });
});