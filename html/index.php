<?php
if (isset($_SESSION['user_id'])) {
    ?>
    <h3>Ваши заявки</h3>
    <div class="row">
        <div class="col col-sm-3">
            <a class="btn btn-primary my-2 w-100" href="/new_form">Создать заявку</a>
        </div>
    </div>
    <!--        <table class="table table-stripped table-hover table-bordered">-->
    <!--            <tr>-->
    <!--                <th>Номер заявки</th>-->
    <!--                <th>Регистрационный номер ТС</th>-->
    <!--                <th>Описание нарушения</th>-->
    <!--                <th>Статус рассмотрения</th>-->
    <!--            </tr>-->
    <div class="row">
    <?php
    if (count($requests) == 0) {
        ?>
        <p>У вас ещё нет заявок</p>
        <?php
    } else {
        foreach ($requests as $request) {
            if ($request->status == "new") {
                $class = "info";
                $st = "Новое";
            } else if ($request->status == "confirmed") {
                $class = "success";
                $st = "Подтверждено";
            } else if ($request->status == "rejected") {
                $class = "danger";
                $st = "Отклонено";
            }
            ?>

            <div class="col-6 col-sm-3">
                <div class="card border">
                    <div class="card-header">Заявка №<?= $request->id ?></div>
                    <div class="card-body">
                        <div class="card-text"><?= $request->description ?></div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Номер ТС: <?= $request->ts_number ?></li>
                    </ul>
                    <div class="card-footer bg-opacity-25 bg-<?= $class ?>">Статус: <?= $st ?></div>
                </div>
            </div>
            <!--            <tr class="align-middle table---><?php //= $class ?><!--">-->
            <!--                <td>--><?php //= $request->id ?><!--</td>-->
            <!--                <td>--><?php //= $request->ts_number ?><!--</td>-->
            <!--                <td>--><?php //= $request->description ?><!--</td>-->
            <!--                <td>-->
            <!--                    <button class="btn btn-sm btn---><?php //= $class ?><!--">--><?php //= $st ?><!--</button>-->
            <!--                </td>-->
            <!--            </tr>-->

            <?php
        }
    } ?>
    </div>
    <!--        </table>-->

    <?php
} else { ?>

    <h1 class="mb-4">Для просмотра ваших заявок, пожалуйста, войдите под своим логином или зарегистрируйтесь</h1>
    <a href="/login_form" class="fs-2 btn btn-primary">Войти</a>
    <a href="/reg_form" class="fs-2 btn btn-primary">Регистрация</a>

    <?php
}
?>
