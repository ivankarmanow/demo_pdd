<div class="row mx-2">
    <div class="col-sm-3"></div>
    <div class="col border border-1 rounded-3 p-3">
        <h2>Регистрация</h2>
        <form action="/reg" method="post" class="needs-validation" id="registrationForm" novalidate>
            <label for="login" class="form-label mt-2">Логин</label>
            <input type="text" name="login" id="login" class="form-control" pattern="^[\-a-z0-9_]{3,16}$" required autocomplete="new-login">
            <span class="invalid-feedback">
                Логин может содержать только английские буквы, цифры и нижнее подчеркивание
            </span>
            <div id="login-exists" class="text-danger" style="display: none;">
                Пользователь с таким логином уже существует!
            </div>
<!--            <span class="valid-feedback">-->
<!--                ок-->
<!--            </span>-->
            <label for="name" class="form-label mt-2">ФИО</label>
            <input type="text" name="name" id="name" class="form-control" pattern="^([а-яёА-ЯЁ]+)\s+([а-яёА-ЯЁ]+)\s*([а-яёА-ЯЁ]+\s*)?$" required>
            <span class="invalid-feedback">
                ФИО должно состоять из 2 или 3 русских слов с заглавными буквами
            </span>
            <label for="email" class="form-label mt-2">E-mail</label>
            <input type="text" name="email" id="email" class="form-control" pattern="^[\-a-zA-Zа-яёА-ЯЁ_0-9]+@[\-a-zA-Z_а-яёА-ЯЁ0-9]+\.[a-zа-яё]{2,5}$" required>
            <span class="invalid-feedback">
                Пожалуйста, введите корректный email
            </span>
            <label for="phone" class="form-label mt-2">Номер телефона</label>
            <div class="input-group">
                <span class="input-group-text">+7 </span>
                <input type="text" name="phone" id="phone" class="form-control" pattern="^\\(\d{3}\)-\d{3}-\d{2}-\d{2}$" required>
            </div>
            <span class="invalid-feedback">
                Пожалуйста, введите корректный номер телефона
            </span>
            <label for="password" class="form-label mt-2">Пароль</label>
            <input type="password" name="password" id="password" pattern="^(?=.*?[A-ZА-Я])(?=.*?[a-zа-я])(?=.*?[0-9])(?=.*?[#?!@$%^&*\-]).{6,}$" class="form-control" required autocomplete="new-password">
            <span class="invalid-feedback">
                Пароль должен содержать минимум 8 символов, включая буквы разных регистров, цифры и специальный символ
            </span>
            <div class="text-danger" id="server_error"></div>
            <div class="row m-0 mt-3">
                <div class="col"></div>
                <button type="submit" class="btn btn-primary col-12 col-sm-5 btn-lg">Зарегистрироваться</button>
                <div class="col"></div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>
