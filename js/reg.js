document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');

    const name = document.getElementById('name');
    const phone = document.getElementById('phone');

    function formatPhone(value) {
        let numbers = value.replace(/\D/g, '');
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

    phone.addEventListener('input', function (e) {
        const cursorPosition = phone.selectionStart;
        const previousLength = phone.value.length;

        phone.value = formatPhone(phone.value);

        const newLength = phone.value.length;
        phone.selectionEnd = cursorPosition + (newLength - previousLength);
    });

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