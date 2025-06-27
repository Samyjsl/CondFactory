document.getElementById('contact-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('../php-backend/mail.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert("Данные отправлены!");
        form.reset();
    })
    .catch(err => {
        alert("Произошла ошибка. Попробуйте позже.");
        console.error(err);
    });
});