<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="" action="<?= base_url('api/usuario/dologin') ?>" method="post">
                        <div class="form-group">
                            <label for="usuario_nombre">Nombre de usuario</label>
                            <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre">
                        </div>
                        <div class="form-group">
                            <label for="usuario_contrasenia">Password</label>
                            <input type="password" class="form-control" name="usuario_contrasenia" id="usuario_contrasenia">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>