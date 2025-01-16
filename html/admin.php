<?php
if (isset($_SESSION['is_admin'])) {
    ?>
    <h3>Заявки</h3>
    <div class="d-flex gap-2 my-2" id="admin-filter">
        <button class="btn btn-secondary" onclick="adminFilter('all')">Все</button>
        <button class="btn btn-info" onclick="adminFilter('new')">Новые</button>
        <button class="btn btn-danger" onclick="adminFilter('rejected')">Отклоненные</button>
        <button class="btn btn-success" onclick="adminFilter('confirmed')">Подтверждённые</button>
    </div>

    <div style="overflow-x: auto">
        <table class="table table-stripped table-hover table-bordered">
            <tr>
                <th>ID заявки</th>
                <th>ФИО заявителя</th>
                <th>Регистрационный номер ТС</th>
                <th>Описание нарушения</th>
                <th>Статус рассмотрения</th>
            </tr>
            <div class="row">
                <?php
                if (count($requests) == 0) {
                    ?>
                    <p>Пока список заявок пуст</p>
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

                        <!--                <div class="col-6 col-sm-3">-->
                        <!--                    <div class="card border">-->
                        <!--                        <div class="card-header">Заявка №--><?php //= $request->id ?><!--</div>-->
                        <!--                        <div class="card-body">-->
                        <!--                            <div class="card-text">--><?php //= $request->description ?><!--</div>-->
                        <!--                        </div>-->
                        <!--                        <ul class="list-group list-group-flush">-->
                        <!--                            <li class="list-group-item">Номер ТС: --><?php //= $request->ts_number ?><!--</li>-->
                        <!--                        </ul>-->
                        <!--                        <div class="card-footer bg-opacity-25 bg---><?php //= $class ?><!--">Статус: --><?php //= $st ?><!--</div>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <tr class="align-middle request-row table-<?= $class ?>" data-status="<?= $request->status ?>">
                            <td><?= $request->id ?></td>
                            <td><?= $request->name ?></td>
                            <td><?= $request->ts_number ?></td>
                            <td><?= $request->description ?></td>
                            <td>
                                <?php if ($request->status == "new") { ?>
                                    <form action="/change_status" method="post">
                                        <input type="hidden" name="rid" value="<?= $request->id ?>">
                                        <button class="btn btn-success" type="submit" name="status" value="confirmed">
                                            Подтвердить
                                        </button>
                                        <button class="btn btn-danger" type="submit" name="status" value="rejected">
                                            Отклонить
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <button class="btn btn-<?= $class ?>"><?= $st ?></button>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php
                    }
                } ?>
            </div>
        </table>
    </div>

    <?php
} else { ?>

    <h1>У вас нет доступа к панели администратора</h1>
    <a href="/" class="btn btn-primary">На главную</a><br>

    <?php
}
?>
