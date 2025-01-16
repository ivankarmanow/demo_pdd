<div class="row mx-2">
    <div class="col-sm-3"></div>
    <div class="col border border-1 rounded-3 p-3">
        <h2>Вход</h2>
        <form action="/login" method="post">
            <label for="login" class="form-label mt-2">Логин:</label>
            <input type="text" name="login" class="form-control <?= $authFail ? 'is-invalid' : '' ?>" value="<?= $oldLogin ?? "" ?>">
            <label for="password" class="form-label mt-2">Пароль</label>
            <input type="password" name="password" class="form-control <?= $authFail ? 'is-invalid' : '' ?>" value="<?= $oldPass ?? "" ?>">
            <?php if ($authFail ?? false) { ?>
<!--                <div class="text-danger my-2" id="auth-error">Неверный логин или пароль</div>-->
                <div class="alert alert-danger mt-2 alert-dismissible fade show" role="alert">
                    Неверный логин или пароль!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
                </div>
            <?php } ?>
            <div class="row m-0 mt-3">
                <div class="col"></div>
                <button type="submit" class="btn btn-primary col-12 col-sm-4 btn-lg" id="liveToastBtn">Войти</button>
                <div class="col"></div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>