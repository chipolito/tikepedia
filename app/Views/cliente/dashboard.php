<?php echo $this->extend('layouts/cliente'); ?>

<?php echo $this->section('contenido'); ?>

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar  d-flex pb-3 pb-lg-5 ">
    <!--begin::Toolbar container-->
    <div class="d-flex flex-stack flex-row-fluid">
        <!--begin::Toolbar container-->
        <div class="d-flex flex-column flex-row-fluid">
            <!--begin::Toolbar wrapper-->                   
            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-lg-2x gap-2">
                    <span>
                        <span class="fw-light">Bienvenido de nuevo</span>,&nbsp; 
                        <?= session()->get('usuario_propietario') ?>
                    </span>
                    <!--begin::Description-->
                    <span class="page-desc text-gray-600 fs-base fw-semibold">
                        Has iniciado sesión como cliente propietario.
                    </span>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->    
            </div>
            <!--end::Page title-->  
        </div>
        <!--end::Toolbar container-->

        <!--begin::Actions-->
        <div class="d-flex align-self-center flex-center flex-shrink-0">
            <a href="javascript:void(0);" class="btn btn-sm btn-success ms-3 px-4 py-3 d-none d-sm-inline">
                <i class="ki-outline ki-plus-square fs-2"></i> <span>Registrar Tarea</span>
            </a>

            <a href="javascript:void(0);" class="btn btn-sm btn-dark ms-3 px-4 py-3 d-none d-sm-inline">
                <i class="ki-outline ki-plus-square fs-2"></i> <span>Registrar Ticket</span>
            </a> 
        </div>
        <!--end::Actions-->  
    </div>
    <!--end::Toolbar container-->    
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content  flex-column-fluid " >

</div>
<!--end::Content-->

<?php echo $this->endSection(); ?>

<?php echo $this->section('customScripts'); ?>

<?php echo $this->endSection(); ?>