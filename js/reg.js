document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');

    // const login = document.getElementById('login');
    const name = document.getElementById('name');
    // const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    // const password = document.getElementById('password');

    // Функция для форматирования номера телефона
    function formatPhone(value) {
        // Удаляем все нецифровые символы
        let numbers = value.replace(/\D/g, '');
        // Ограничиваем длину до 11 цифр (для +7)
        numbers = numbers.substring(0, 10);

        let formatted = '(';
        if (numbers.length > 0) {
            formatted += numbers.substring(0, 3);
        }
        if (numbers.length >= 4) {
            formatted += ')-' + numbers.substring(3, 6);
        }
        if (numbers.length >= 7) {
            formatted += '-' + numbers.substring(6, 8);
        }
        if (numbers.length >= 9) {
            formatted += '-' + numbers.substring(8, 10);
        }
        if (formatted.length > 1) {
            return formatted;
        } else {
            return '';
        }
    }

    // Добавляем обработчик ввода для форматирования телефона в реальном времени
    phone.addEventListener('input', function (e) {
        const cursorPosition = phone.selectionStart;
        const previousLength = phone.value.length;

        phone.value = formatPhone(phone.value);

        const newLength = phone.value.length;
        phone.selectionEnd = cursorPosition + (newLength - previousLength);
    });

    // Функция для приведения ФИО к правильному регистру
    function formatName(value) {
        return value.split(' ').map(word => {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }).join(' ');
    }

    function showError(text) {
        document.getElementById("server_error").innerHTML = text;
    }

    form.addEventListener('submit', async function (event) {
        name.value = formatName(name.value);
        form.classList.add("was-validated");
        document.getElementById("login-exists").style.display = "none";

        event.preventDefault();
        event.stopPropagation();

        if (!form.checkValidity()) {
            return;
        }

        let data = new FormData(this);
        let resp = await fetch("/reg", {
            "method": "POST",
            "body": data
        });
        if (!resp.ok) {
            showError("Ошибка отправки формы");
            return;
        }
        data = await resp.json();
        console.log(data);
        if (!data.status) {
            for (var key in data.errors) {
                if (data.errors[key] == "pattern") {
                    showError(`Неверный формат поля ${key}<br>`);
                } else if (data.errors[key] == "exists") {
                    // showError(`Пользователь с таким логином уже существует!`);
                    document.getElementById("login-exists").style.display = "block";
                    document.getElementById("login").classList.add("invalid-c");
                } else {
                    showError("Неизвестная ошибка сервера");
                }
            }
        } else {
            window.location.href = "/";
        }
    });
});

        // const loginRegex = /^[A-Za-z0-9_]+$/;
        // if (!loginRegex.test(login.value)) {
        //     login.classList.add('is-invalid');
        //     isValid = false;
        // } else {
        //     login.classList.remove('is-invalid');
        //     login.classList.add('is-valid');
        // }

        // Валидация ФИО
        // const nameRegex = /^([А-ЯЁ][а-яё]+)\s([А-ЯЁ][а-яё]+)(\s[А-ЯЁ][а-яё]+)?$/;
        // if (!nameRegex.test(name.value.trim())) {
        //     name.classList.add('is-invalid');
        //     isValid = false;
        // } else {
        //     // Приведение к правильному регистру
        //     name.value = formatName(name.value.trim());
        //     name.classList.remove('is-invalid');
        //     name.classList.add('is-valid');
        // }

        // Валидация Email
        // if (!email.checkValidity()) {
        //     email.classList.add('is-invalid');
        //     isValid = false;
        // } else {
        //     email.classList.remove('is-invalid');
        //     email.classList.add('is-valid');
        // }

        // Валидация Телефона
        // const phoneRegex = /^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/;
        // if (!phoneRegex.test(phone.value)) {
        //     phone.classList.add('is-invalid');
        //     isValid = false;
        // } else {
        //     phone.classList.remove('is-invalid');
        //     phone.classList.add('is-valid');
        // }

        // Валидация Пароля
        // const passwordValue = password.value;
        // const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        // if (!passwordRegex.test(passwordValue)) {
        //     password.classList.add('is-invalid');
        //     isValid = false;
        // } else {
        //     password.classList.remove('is-invalid');
        //     password.classList.add('is-valid');
        // }

        // if (isValid) {
        //     // Если форма валидна, можно отправить её
        //     form.submit();
        // } else {
        //     // Добавляем класс для отображения ошибок Bootstrap
        //     form.classList.add('was-validated');
        // }
    // });

    // Очистка классов при вводе
    // const inputs = [login, name, email, phone, password];
    // inputs.forEach(input => {
    //     input.addEventListener('input', function () {
    //         if (input.classList.contains('is-invalid')) {
    //             input.classList.remove('is-invalid');
    //         }
    //         if (input.classList.contains('is-valid')) {
    //             input.classList.remove('is-valid');
    //         }
    //     });
    // });
// });