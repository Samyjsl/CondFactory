function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.classList.add('modal-open');
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.classList.remove('modal-open');
}

// Проверка авторизации перед переходом
function checkAuthAndRedirect(event, targetUrl) {
    event.preventDefault();

    fetch('../php-backend/check-auth.php')
        .then(response => response.json())
        .then(data => {
            if (data.authorized) {
                window.location.href = targetUrl;
            } else {
                openModal('modal-register');
            }
        });
}

// Cсылки в header
document.querySelectorAll('.header-link').forEach(link => {
    const url = link.getAttribute('href');
    link.addEventListener('click', (e) => checkAuthAndRedirect(e, url));
});

// Переключение: регистрация - авторизация
document.getElementById('link-btn-avto').addEventListener('click', function (e) {
    e.preventDefault();
    closeModal('modal-register');
    openModal('modal-avto');
});

// Переключение: авторизация - регистрация
document.getElementById('link-btn-reg').addEventListener('click', function (e) {
    e.preventDefault();
    closeModal('modal-avto');
    openModal('modal-register');
});

// Закрытие модалки при клике вне формы
window.addEventListener('click', function (event) {
    const modalReg = document.getElementById('modal-register');
    const modalAvto = document.getElementById('modal-avto');

    if (event.target === modalReg) {
        closeModal('modal-register');
    }

    if (event.target === modalAvto) {
        closeModal('modal-avto');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Регистрация
    const regForm = document.querySelector('#modal-register form');
    if (regForm) {
        regForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const password = regForm.password.value.trim();
            const confirm = regForm.confirm_password.value.trim();

            if (password !== confirm) {
                alert('Пароли не совпадают');
                return;
            }

            const formData = new FormData(regForm);
            const res = await fetch('../php-backend/reg.php', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();
            alert(data.message);
        });
    }

    // Авторизация
    const avtoForm = document.querySelector('#modal-avto form');
    if (avtoForm) {
        avtoForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(avtoForm);

            const res = await fetch('../php-backend/avto.php', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();
            alert(data.message);

            if (data.success) {
                if (data.user_type == 2) {
                    window.location.href = 'admin/main-menu.php';
                } else {
                    document.getElementById('modal-avto').style.display = 'none';
                    location.reload();
                }
            }
        });
    }
});



// Оповещения для alert
