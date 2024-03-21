<?= $this->extend("layouts/agente") ?>

<?= $this->section("body") ?>

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Agente Dashboard</div>
                <div class="panel-body">
                    <h1>Hello, <?= session()->get('usuario_propietario') ?></h1>
                    <h3><a href="<?= site_url('logout') ?>">Logout</a></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>