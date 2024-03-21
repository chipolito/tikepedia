<?php echo $this->extend('layouts/cliente'); ?>

<?php echo $this->section('contenido'); ?>

<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Cliente Dashboard</div>
                <div class="panel-body">
                    <h1>Hello, <?= session()->get('usuario_propietario') ?></h1>
                    <h3><a href="<?= site_url('logout') ?>">Logout</a></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('customScripts'); ?>
<script>
    console.log('Entro js');
</script>
<?php echo $this->endSection(); ?>