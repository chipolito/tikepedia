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
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-12">

            <!--begin::Resumen general-->
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header position-relative py-0 border-bottom-2">
                     <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">Resumen de tickets</span>
                        <span class="text-gray-500 mt-1 fw-semibold fs-7">Conteo general de todos los tickets agrupados por estatus</span>
                    </h3>
                    <!--end::Title-->  
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pb-3">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-wrap flex-md-nowrap">
                        <!--begin::Items-->
                        <div class="me-md-5 w-100">
                            <!--begin::Item Nuevo-->
                            <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                <!--begin::Block-->
                                <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label">
                                            <i class="ki-outline ki-tablet-book fs-2qx text-primary"></i>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Section-->
                                    <div class="me-2">
                                        <a href="javascript:void(0);" class="text-gray-800 text-hover-primary fs-6 fw-bold">Tickets Nuevos / Abiertos</a>
                                        <span class="text-gray-500 fw-bold d-block fs-7">Tickets registrados sin atender</span>
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Block-->  
                                
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-900 fw-bolder fs-2x">0</span>
                                    <span class="fw-semibold fs-2 text-gray-600 mx-1 pt-1 me-2">/</span>
                                    <span class="badge badge-lg badge-dark align-self-center px-2">0%</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item Asignado-->
                            <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                <!--begin::Block-->
                                <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label">
                                            <i class="ki-outline ki-heart-circle fs-2qx text-primary"></i>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Section-->
                                    <div class="me-2">
                                        <a href="javascript:void(0);" class="text-gray-800 text-hover-primary fs-6 fw-bold">Tickets Atendidos / Asignados</a>
                                        <span class="text-gray-500 fw-bold d-block fs-7">Tickets que ya están en proceso</span>
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Block-->  
                                
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-900 fw-bolder fs-2x">0</span>
                                    <span class="fw-semibold fs-2 text-gray-600 mx-1 pt-1 me-2">/</span>
                                    <span class="badge badge-lg badge-dark align-self-center px-2">0%</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item Cerrado-->
                            <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                <!--begin::Block-->
                                <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label">
                                            <i class="ki-outline ki-like-shapes fs-2qx text-primary"></i>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Section-->
                                    <div class="me-2">
                                        <a href="javascript:void(0);" class="text-gray-800 text-hover-primary fs-6 fw-bold">Tickets cerrados</a>
                                        <span class="text-gray-500 fw-bold d-block fs-7">Tickets que han concluido su ciclo de atención pero no se han marcado como asunto Finalizado</span>
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Block-->  

                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-900 fw-bolder fs-2x">0</span>
                                    <span class="fw-semibold fs-2 text-gray-600 mx-1 pt-1 me-2">/</span>
                                    <span class="badge badge-lg badge-dark align-self-center px-2">0%</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Item Finalizados-->
                            <div class="d-flex border border-gray-300 border-dashed rounded p-6 mb-6">
                                <!--begin::Block-->
                                <div class="d-flex align-items-center flex-grow-1 me-2 me-sm-5">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label">
                                            <i class="ki-outline ki-medal-star fs-2qx text-primary"></i>
                                        </span>
                                    </div>
                                    <!--end::Symbol-->

                                    <!--begin::Section-->
                                    <div class="me-2">
                                        <a href="javascript:void(0);" class="text-gray-800 text-hover-primary fs-6 fw-bold">Tickets Finalizados / Resueltos</a>
                                        <span class="text-gray-500 fw-bold d-block fs-7">Tickets que se han cerrado con éxito y se han marcado como solucionados.</span>
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Block-->  

                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <span class="text-gray-900 fw-bolder fs-2x">0</span>
                                    <span class="fw-semibold fs-2 text-gray-600 mx-1 pt-1 me-2">/</span>
                                    <span class="badge badge-lg badge-dark align-self-center px-2">0%</span>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Items--> 
                                    
                        <!--begin::Container-->
                        <div class="d-flex justify-content-between flex-column w-225px w-md-600px mx-auto mx-md-0 pt-3 pb-10">
                            <!--begin::Title-->
                            <div class="fs-4 fw-bold text-gray-900 text-center mb-5">
                                Avances y porcentaje de atención
                            </div>
                            <!--end::Title--> 

                            <!--begin::Chart-->
                            <div id="kt_chart_widget_avance" class="mx-auto mb-4"></div>
                            <!--end::Chart-->

                            <!--begin::Labels-->
                            <div class="mx-auto">
                                <!--begin::Label-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Bullet-->
                                    <div class="bullet bullet-dot w-8px h-7px bg-danger me-2"></div>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="fs-7 fw-semibold text-muted">Atrasados (0)</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                                
                                <!--begin::Label-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Bullet-->
                                    <div class="bullet bullet-dot w-8px h-7px bg-warning me-2"></div>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="fs-7 fw-semibold text-muted">Sin atender (0)</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->   

                                <!--begin::Label-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Bullet-->
                                    <div class="bullet bullet-dot w-8px h-7px bg-success me-2"></div>
                                    <!--end::Bullet-->

                                    <!--begin::Label-->
                                    <div class="fs-7 fw-semibold text-muted">Otros (0)</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Labels-->                                
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Wrapper-->    
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Resumen general-->

        </div>
    </div>
</div>
<!--end::Content-->

<?php echo $this->endSection(); ?>

<?php echo $this->section('customScripts'); ?>

<script src="<?= base_url('assets/js/custom/cliente/board.js') ?>"></script>

<?php echo $this->endSection(); ?>