<?php echo $this->extend('layouts/cliente'); ?>

<?php echo $this->section('customCss'); ?>

<link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css') ?>" rel="stylesheet" type="text/css">

<?php echo $this->endSection(); ?>

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
                    <span>Tickets Atrasados</span>
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->

            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3 fs-7">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    <a href="javascript:void(0)" class="text-white text-hover-primary">
                        <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                    </a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    Centro de soporte
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                    Tickets
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-700">
                    Listado completo de Tickets atrasados
                </li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar container-->
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content  flex-column-fluid">
    <!--begin::Tickets-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                    <input type="text" data-kt-custom-ticket-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar Ticket"/>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Flatpickr-->
                <div class="input-group w-300px">
                    <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Buscar por rango de fecha" id="kt_custom_ticket_flatpickr" />
                    <button class="btn btn-icon btn-light" id="kt_custom_ticket_flatpickr_clear">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </button>
                </div>
                <!--end::Flatpickr-->

                <!-- <div class="w-100 mw-150px">
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Estado" data-kt-ecommerce-order-filter="status">
                        <option></option>
                        <option value="all">Todos</option>
                        <option value="Cancelled">Nuevo</option>
                        <option value="Completed">Sin atender</option>
                        <option value="Denied">En progreso</option>
                        <option value="Expired">Atrasado</option>
                        <option value="Failed">Cerrado</option>
                        <option value="Pending">Finalizado</option>
                    </select>
                </div> -->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_custom_ticket_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">Folio</th>
                        <th class="min-w-100px">Departamento</th>
                        <th class="min-w-100px">Tema</th>
                        <th class="min-w-175px">Asunto</th>
                        <th class="min-w-100px">Registro</th>
                        <th class="min-w-100px">Ultimo movimiento</th>
                        <th class="min-w-100px">Atraso</th>
                    </tr>
                </thead>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Tickets-->
</div>
<!--end::Content-->

<?php echo $this->endSection(); ?>

<?php echo $this->section('customScripts'); ?>

<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/custom/cliente/tickets.atrasados.js') ?>"></script>

<?php echo $this->endSection(); ?>