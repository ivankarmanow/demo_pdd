<div class="row mx-2">
    <div class="col-sm-3"></div>
    <div class="col border border-1 rounded-3 p-3">
        <h2>Новая заявка</h2>
        <form action="/new" method="post" novalidate>
            <label for="ts_number" class="form-label mt-2">Номер транспортного средства</label>
            <input type="text" name="ts_number" class="form-control" id="ts" required pattern="^[АВЕКМНОРСТУХ]{0,2}\s?[0-9]{1,4}\s?[АВЕКМНОРСТУХ]{0,2}\s?[0-9]{1,3}$">
            <div class="invalid-feedback">
                Неверный формат номера ТС
            </div>
            <label for="description" class="form-label mt-2">Описание нарушения</label>
            <textarea name="description" class="form-control" cols="30" rows="10" style="resize: vertical" required></textarea>
            <div class="invalid-feedback">
                Заполните описание
            </div>
            <div class="row m-0 mt-2">
                <div class="col"></div>
                <button type="submit" class="btn btn-primary col-12 col-sm-4 btn-lg">Создать заявку</button>
                <div class="col"></div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>