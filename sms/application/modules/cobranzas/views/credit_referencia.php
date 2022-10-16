    <div class="form-group">
        <div class="col-md-3">Nombres *</div>
        <div class="col-md-9"><input class="form-control" id="<?= $prefix ?>firstname" type="text" name="<?= $prefix ?>firstname" maxlength="128" value="<?= $person_model->firstname ?>"  placeholder="Nombres de la Referencia" /> </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">Apellidos</div>
        <div class="col-md-9"><input class="form-control" id="<?= $prefix ?>lastname" type="text" name="<?= $prefix ?>lastname" maxlength="128" value="<?= $person_model->lastname ?>"  placeholder="Apellidos de la Referencia" /> </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">Telefono</div>
        <div class="col-md-9"><input class="form-control" id="<?= $prefix ?>personal_phone" type="text" name="<?= $prefix ?>personal_phone" maxlength="128" value="<?= $person_model->personal_phone ?>"  placeholder="Telefono de la Referencia" /> </div>
    </div>
    <div class="form-group">
        <div class="col-md-3">Direccion</div>
        <div class="col-md-9"><input class="form-control" id="<?= $prefix ?>personal_address" type="text" name="<?= $prefix ?>personal_address" maxlength="128" value="<?= $person_model->personal_address ?>"  placeholder="Direccion" /> </div>
    </div>