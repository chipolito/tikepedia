<!DOCTYPE html>
<html lang="es">
    <!--begin::Head-->
    <head>
        <title>TicketPedia - Cree tickets y administre el soporte sin esfuerzo</title>

        <meta charset="utf-8"/>
        <meta name="description" content="Administre los tickets con la ayuda de etiquetas, prioridad, estado y etiquetas para un mejor flujo de trabajo y búsqueda. Asigne agentes, agregue notas privadas, reenvíe respuestas a otro agente para una mejor gestión de tickets."/>
        <meta name="keywords" content="HelpDesk, Ingeniero, Agente, Cliente"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <meta property="og:locale" content="es_MX" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="TicketPedia - Cree tickets y administre el soporte sin esfuerzo" />
        <meta property="og:url" content="<?= base_url() ?>"/>
        <meta property="og:site_name" content="TicketPedia" />

        <link rel="canonical" href="index.html"/>
        <link rel="shortcut icon" href="<?= base_url('assets/images/business/logo-small.ico') ?>"/>

        <!--begin::Fonts(mandatory for all pages)-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
        <!--end::Fonts-->

        <?php echo $this->renderSection('customCss') ?>
        
        <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
        <link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css"/>
        <!--end::Global Stylesheets Bundle-->

        <script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
            if (window.top != window.self) {
                window.top.location.replace(window.self.location.href);
            }
        </script>
    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_app_body" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"  class="app-default" >
        <!--begin::Theme mode setup on page load-->
        <script>
            var defaultThemeMode = "light";
            var themeMode;

            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if ( localStorage.getItem("data-bs-theme") !== null ) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }			
                }

                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }

                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }            
        </script>
        <!--end::Theme mode setup on page load-->

        <!--begin::App-->
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <!--begin::Page-->
            <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
                <!--begin::Header-->
                <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate-="true" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Header container-->
                    <div class="app-container  container-xxl d-flex align-items-stretch justify-content-between " id="kt_app_header_container">
                        <!--begin::Header wrapper-->
                        <div class="app-header-wrapper d-flex flex-grow-1 align-items-stretch justify-content-between" id="kt_app_header_wrapper">
                            <!--begin::Logo wrapper-->
                            <div class="app-header-logo d-flex flex-shrink-0 align-items-center justify-content-between justify-content-lg-center">
                                <!--begin::Logo wrapper-->
                                <button class="btn btn-icon btn-color-gray-600 btn-active-color-primary ms-n3 me-2 d-flex d-lg-none" id="kt_app_sidebar_toggle">
                                    <i class="ki-outline ki-abstract-14 fs-2"></i>
                                </button>
                                <!--end::Logo wrapper-->
                                <!--begin::Logo image-->
                                <a href="javascript:void(0);">
                                    <img alt="Logo" src="<?= base_url('assets/images/business/logo.png') ?>" class="h-40px h-lg-70px theme-light-show"/>
                                    <img alt="Logo" src="<?= base_url('assets/images/business/logo-w.png') ?>" class="h-40px h-lg-70px theme-dark-show"/>
                                </a>
                                <!--end::Logo image--> 
                            </div>
                            <!--end::Logo wrapper-->

                            <!--begin::Menu wrapper-->
                            <div id="kt_app_header_menu_wrapper" class="d-flex align-items-center w-100">
                                <!--begin::Header menu-->
                                <div 
                                    class="app-header-menu app-header-mobile-drawer align-items-start align-items-lg-center w-100"
                                    data-kt-drawer="true"
                                    data-kt-drawer-name="app-header-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}"
                                    data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="250px"
                                    data-kt-drawer-direction="end"
                                    data-kt-drawer-toggle="#kt_app_header_menu_toggle"
                                    data-kt-swapper="true"
                                    data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                                    data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_menu_wrapper'}"
                                    >
                                    <!--begin::Menu-->
                                    <div class="
                                        menu 
                                        menu-rounded  
                                        menu-column 
                                        menu-lg-row 
                                        menu-active-bg
                                        menu-state-primary
                                        menu-title-gray-700 
                                        menu-arrow-gray-500 
                                        menu-bullet-gray-500
                                        my-5 
                                        my-lg-0 
                                        align-items-stretch 
                                        fw-semibold
                                        px-2 
                                        px-lg-0 
                                        "
                                        id="#kt_header_menu" 
                                        data-kt-menu="true"
                                        >
                                        <!--begin:Menu item-->
                                        <div  class="menu-item menu-here-bg me-0 me-lg-2 link-inicio" >
                                            <!--begin:Menu link-->
                                            <a href="<?= base_url('cliente') ?>" class="menu-link">
                                                <span  class="menu-title" >Inicio</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>

                                        <!--begin:Menu item-->
                                        <div  data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" data-kt-menu-offset="-100,0"  class="menu-item menu-lg-down-accordion me-0 me-lg-2" >
                                            <!--begin:Menu link-->
                                            <span class="menu-link">
                                                <span  class="menu-title">Herramientas</span>
                                                <span  class="menu-arrow d-lg-none" ></span>
                                            </span>
                                            <!--end:Menu link-->
                                            
                                            <!--begin:Menu sub-->
                                            <div  class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-850px" >
                                                <!--begin:Base de conocimiento menu-->
                                                <div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
                                                    <!--begin:Row-->
                                                    <div class="row">
                                                        <!--begin:Col-->
                                                        <div class="col-lg-8 mb-3 mb-lg-0  py-3 px-3 py-lg-6 px-lg-6">
                                                            <!--begin:Row-->
                                                            <div class="row">
                                                                <!--begin:Col-->
                                                                <div class="col-lg-6 mb-3">
                                                                    <!--begin:Menu item-->
                                                                    <div class="menu-item p-0 m-0">
                                                                        <!--begin:Menu link-->
                                                                        <a href="javascript:void(0);" class="menu-link">
                                                                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                                                <i class="ki-outline ki-element-11 text-primary fs-1"></i>
                                                                            </span>
                                                                            <span class="d-flex flex-column">
                                                                                <span class="fs-6 fw-bold text-gray-800">Base de conocimiento</span>
                                                                                <span class="fs-7 fw-semibold text-muted">Centro de información</span>
                                                                            </span>
                                                                        </a>
                                                                        <!--end:Menu link-->
                                                                    </div>
                                                                    <!--end:Menu item-->
                                                                </div>
                                                                <!--end:Col-->

                                                                <!--begin:Col-->
                                                                <div class="col-lg-6 mb-3">
                                                                    <!--begin:Menu item-->
                                                                    <div class="menu-item p-0 m-0">
                                                                        <!--begin:Menu link-->
                                                                        <a href="javascript:void(0);" class="menu-link ">
                                                                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                                                <i class="ki-outline ki-switch text-warning fs-1"></i>
                                                                            </span>
                                                                            <span class="d-flex flex-column">
                                                                                <span class="fs-6 fw-bold text-gray-800">Lista de tarea</span>
                                                                                <span class="fs-7 fw-semibold text-muted">Actividades pendientes</span>
                                                                            </span>
                                                                        </a>
                                                                        <!--end:Menu link-->
                                                                    </div>
                                                                    <!--end:Menu item-->
                                                                </div>
                                                                <!--end:Col-->
                                                                
                                                                <!--begin:Col-->
                                                                <div class="col-lg-6 mb-3">
                                                                    <!--begin:Menu item-->
                                                                    <div class="menu-item p-0 m-0">
                                                                        <!--begin:Menu link-->
                                                                        <a href="javascript:void(0);" class="menu-link ">
                                                                            <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
                                                                                <i class="ki-outline ki-color-swatch text-success fs-1"></i>
                                                                            </span>
                                                                            <span class="d-flex flex-column">
                                                                                <span class="fs-6 fw-bold text-gray-800">Reportes</span>
                                                                                <span class="fs-7 fw-semibold text-muted">Graficas de progreso</span>
                                                                            </span>
                                                                        </a>
                                                                        <!--end:Menu link-->
                                                                    </div>
                                                                    <!--end:Menu item-->
                                                                </div>
                                                                <!--end:Col-->
                                                            </div>
                                                            <!--end:Row-->

                                                            <div class="separator separator-dashed mx-5 my-5"></div>

                                                            <!--begin:mensaje-->
                                                            <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-2 mx-5">
                                                                <div class="d-flex flex-column me-5">
                                                                    <div class="fs-6 fw-bold text-gray-800">
                                                                        Alertas y notificaciones activas
                                                                    </div>
                                                                    <div class="fs-7 fw-semibold text-muted">
                                                                        Revisa tu bandeja de entrada, siempre recibirás las actualizaciones de tus tickets.
                                                                    </div>
                                                                </div>

                                                                <span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-50px h-50px">
                                                                    <i class="ki-outline ki-call  text-primary fs-1"></i>
                                                                </span>
                                                            </div>
                                                            <!--end:mensaje-->
                                                        </div>
                                                        <!--end:Col-->

                                                        <!--begin:Col-->
                                                        <div class="menu-more bg-light col-lg-4 py-3 px-3 py-lg-6 px-lg-6 rounded-end">
                                                            <!--begin:Heading-->
                                                            <h4 class="fs-6 fs-lg-4 text-gray-800 fw-bold mt-3 mb-3 ms-4">Contacto</h4>
                                                            <!--end:Heading-->
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item p-0 m-0">
                                                                <!--begin:Menu link-->
                                                                <a href="javascript:void(0);" class="menu-link py-2 ">
                                                                    <span class="menu-title">RRHH (938-000-0000)</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->

                                                            <!--begin:Menu item-->
                                                            <div class="menu-item p-0 m-0">
                                                                <!--begin:Menu link-->
                                                                <a href="javascript:void(0);" class="menu-link py-2 ">
                                                                    <span class="menu-title">TIC (930-000-0000)</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->
                                                        </div>
                                                        <!--end:Col-->     
                                                    </div>
                                                    <!--end:Row-->
                                                </div>
                                                <!--end:Dashboards menu-->
                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->      
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Header menu-->
                            </div>
                            <!--end::Menu wrapper-->

                            <!--begin::Navbar-->
                            <div class="app-navbar flex-shrink-0">
                                <!--begin::Notificaciones-->
                                <div class="app-navbar-item ms-1 ms-lg-5">
                                    <!--begin::Menu wrapper-->
                                    <div class="btn btn-icon btn-custom btn-active-color-dark btn-color-gray-700 w-35px h-35px w-md-40px h-md-40px position-relative">
                                        <i class="ki-outline ki-notification-on fs-1"></i>             
                                    </div>
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::Notificaciones-->

                                <!--begin::Ayuda-->
                                <div class="app-navbar-item ms-1 ms-lg-5">
                                    <!--begin::Menu wrapper-->
                                    <div class="btn btn-icon btn-custom btn-active-color-dark btn-color-gray-700 w-35px h-35px w-md-40px h-md-40px position-relative">
                                        <i class="ki-outline ki-question fs-1"></i>             
                                    </div>
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::Ayuda-->

                                <!--begin::Nuevo ticket-->
                                <div class="app-navbar-item ms-1 ms-lg-5 d-lg-none kt_drawer_ticket_nuevo_toggle">
                                    <!--begin::Menu wrapper-->
                                    <div class="btn btn-icon btn-custom btn-active-color-dark btn-color-gray-700 w-35px h-35px w-md-40px h-md-40px position-relative">
                                        <i class="ki-outline ki-message-add fs-1"></i>             
                                    </div>
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::Nuevo ticket-->

                                <!--begin::User menu-->
                                <div class="app-navbar-item ms-3 ms-lg-5" id="kt_header_user_menu_toggle">
                                    <!--begin::Menu wrapper-->
                                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px"
                                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" 
                                        data-kt-menu-attach="parent" 
                                        data-kt-menu-placement="bottom-end">
                                        <img class="symbol symbol-circle symbol-35px symbol-md-40px" src="<?= base_url('assets/images/usuario/' . session()->get('usuario_avatar')) ?>" alt="user"/>             
                                    </div>
                                    <!--begin::User account menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content d-flex align-items-center px-3">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-5">
                                                    <img alt="Logo" src="<?= base_url('assets/images/usuario/' . session()->get('usuario_avatar')) ?>"/>
                                                </div>
                                                <!--end::Avatar-->

                                                <!--begin::Username-->
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5">
                                                        Cliente #00<?= session()->get('usuario_id') ?>
                                                    </div>
                                                    <a href="javascript:void(0);" class="fw-semibold text-muted text-hover-primary fs-7">
                                                        <?= session()->get('usuario_email') ?>
                                                    </a>
                                                </div>
                                                <!--end::Username-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <a href="javascript:void(0);" class="menu-link px-5">
                                                Mi perfil
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                            <a href="javascript:void(0);" class="menu-link px-5">
                                                <span class="menu-title position-relative">
                                                    Tema 
                                                    <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                        <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                                        <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                                    </span>
                                                </span>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3 my-0">
                                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-night-day fs-2"></i>            </span>
                                                    <span class="menu-title">
                                                    Light
                                                    </span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3 my-0">
                                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-moon fs-2"></i>            </span>
                                                    <span class="menu-title">
                                                    Dark
                                                    </span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3 my-0">
                                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                                    <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-outline ki-screen fs-2"></i>            </span>
                                                    <span class="menu-title">
                                                    System
                                                    </span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-5">
                                            <a href="javascript:void(0);" class="menu-link px-5" id="btnCerrarSession">
                                                Cerrar sesión
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::User account menu-->
                                    <!--end::Menu wrapper-->
                                </div>
                                <!--end::User menu-->
                                <!--begin::Header menu toggle-->
                                <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                                    <div class="btn btn-icon btn-custom btn-active-color-primary btn-color-gray-700 w-35px h-35px w-md-40px h-md-40px" id="kt_app_header_menu_toggle">
                                        <i class="ki-outline ki-text-align-left fs-1"></i>            
                                    </div>
                                </div>
                                <!--end::Header menu toggle-->
                            </div>
                            <!--end::Navbar-->	
                        </div>
                        <!--end::Header wrapper-->            
                    </div>
                    <!--end::Header container-->
                </div>
                <!--end::Header-->

                <!--begin::Wrapper-->
                <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
                    <!--begin::Wrapper container-->
                    <div class="app-container  container-xxl d-flex flex-row-fluid ">
                        <!--begin::Sidebar-->
                        <div id="kt_app_sidebar" class="app-sidebar  flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="275px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_toggle">
                            <!--begin::Sidebar nav-->
                            <div class="app-sidebar-wrapper py-8" id="kt_app_sidebar_wrapper">
                                <!--begin::Nav wrapper-->
                                <div
                                    id="kt_app_sidebar_nav_wrapper"
                                    class="d-flex flex-column px-8 px-lg-10 hover-scroll-y"        
                                    data-kt-scroll="true"
                                    data-kt-scroll-activate="true"
                                    data-kt-scroll-max-height="auto"     
                                    data-kt-scroll-dependencies="{default: false, lg: '#kt_app_header'}"
                                    data-kt-scroll-wrappers="#kt_app_sidebar, #kt_app_sidebar_wrapper" 
                                    data-kt-scroll-offset="{default: '10px', lg: '40px'}"
                                    >

                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column w-100 mb-2">
                                        <div class="d-flex justify-content-between fw-bolder fs-6 text-gray-800  w-100 mt-auto mb-2">
                                            <span>Progreso de resultados</span>
                                        </div>
                                        
                                        <div class="w-100 bg-light-dark rounded mb-0" style="height: 20px">
                                            <div class="bg-warning rounded" role="progressbar" style="height: 20px; width: 37%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <div class="fw-semibold fs-7 text-gray-700 w-100 mt-auto">
                                            <span>37% general de respuesta.</span>
                                        </div>
                                    </div>
                                    <!--end::Progress--> 

                                    <!--begin::Links-->
                                    <div class="mb-0">
                                        <!--begin::Title-->
                                        <h3 class="text-gray-800 fw-bold mb-5">Tickets</h3>
                                        <!--end::Title-->

                                        <!--begin::Row-->
                                        <div class="row g-5" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Link-->
                                                <a href="<?= base_url('cliente/tickets_nuevos') ?>" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 link-nuevo" data-kt-button="true">
                                                    <!--begin::Icon-->
                                                    <span class="mb-2">
                                                        <i class="ki-outline ki-tablet-book fs-1"></i>
                                                    </span> 
                                                    <!--end::Icon-->
                                                    <!--begin::Label-->
                                                    <span class="fs-7 fw-bold">Nuevos</span> 
                                                    <!--end::Label-->
                                                </a>
                                                <!--end::Link-->  
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Link-->
                                                <a href="<?= base_url('cliente/tickets_sin_atencion') ?>" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 link-sin-atender" data-kt-button="true">
                                                    <!--begin::Icon-->
                                                    <span class="mb-2">
                                                        <i class="ki-outline ki-pulse fs-1"></i>
                                                    </span> 
                                                    <!--end::Icon-->
                                                    <!--begin::Label-->
                                                    <span class="fs-7 fw-bold">Sin atender</span> 
                                                    <!--end::Label-->
                                                </a>
                                                <!--end::Link-->  
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Link-->
                                                <a href="<?= base_url('cliente/tickets_en_proceso') ?>" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 link-en-proceso" data-kt-button="true">
                                                    <!--begin::Icon-->
                                                    <span class="mb-2">
                                                        <i class="ki-outline ki-heart-circle fs-1"></i>
                                                    </span> 
                                                    <!--end::Icon-->
                                                    <!--begin::Label-->
                                                    <span class="fs-7 fw-bold">En proceso</span> 
                                                    <!--end::Label-->
                                                </a>
                                                <!--end::Link-->  
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Link-->
                                                <a href="<?= base_url('cliente/tickets_atrasados') ?>" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 link-atrasados" data-kt-button="true">
                                                    <!--begin::Icon-->
                                                    <span class="mb-2">
                                                        <i class="ki-outline ki-calendar fs-1"></i>
                                                    </span> 
                                                    <!--end::Icon-->
                                                    <!--begin::Label-->
                                                    <span class="fs-7 fw-bold">Atrasados</span> 
                                                    <!--end::Label-->
                                                </a>
                                                <!--end::Link-->  
                                            </div>
                                            <!--end::Col-->  
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Link-->
                                                <a href="<?= base_url('cliente/tickets_por_aprobar') ?>" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 link-por-aprobar" data-kt-button="true">
                                                    <!--begin::Icon-->
                                                    <span class="mb-2">
                                                        <i class="ki-outline ki-like-shapes fs-1"></i>
                                                    </span> 
                                                    <!--end::Icon-->
                                                    <!--begin::Label-->
                                                    <span class="fs-7 fw-bold">Por aprobar</span> 
                                                    <!--end::Label-->
                                                </a>
                                                <!--end::Link-->  
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-6">
                                                <!--begin::Link-->
                                                <a href="<?= base_url('cliente/tickets_finalizados') ?>" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 link-finalizados" data-kt-button="true">
                                                    <!--begin::Icon-->
                                                    <span class="mb-2">
                                                        <i class="ki-outline ki-medal-star fs-1"></i>
                                                    </span> 
                                                    <!--end::Icon-->
                                                    <!--begin::Label-->
                                                    <span class="fs-7 fw-bold">Finalizados</span> 
                                                    <!--end::Label-->
                                                </a>
                                                <!--end::Link-->  
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->  
                                    </div>
                                    <!--end::Links-->
                                </div>
                                <!--end::Nav wrapper-->
                            </div>
                            <!--end::Sidebar nav-->    
                        </div>
                        <!--end::Sidebar-->

                        <!--begin::Main-->
                        <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                            <!--begin::Content wrapper-->
                            <div class="d-flex flex-column flex-column-fluid">
                                <?php echo $this->renderSection('contenido') ?>
                            </div>
                            <!--end::Content wrapper-->

                            <!--begin::Footer-->
                            <div id="kt_app_footer" class="app-footer  d-flex flex-column flex-md-row align-items-center flex-center flex-md-stack py-2 py-lg-4 " >
                                <!--begin::Copyright-->
                                <div class="text-gray-900 order-2 order-md-1">
                                    <span class="text-muted fw-semibold me-1">2024&copy;</span>
                                    <a href="javascript:void(0);" target="_blank" class="text-gray-800 text-hover-primary">TicketPedia</a>
                                </div>
                                <!--end::Copyright-->

                                <!--begin::Menu-->
                                <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                    <li class="menu-item"><a href="javascript:void(0);" target="_blank" class="menu-link px-2">Acerca de</a></li>
                                    <li class="menu-item"><a href="javascript:void(0);" target="_blank" class="menu-link px-2">Apoyo</a></li>
                                    <li class="menu-item"><a href="javascript:void(0);" target="_blank" class="menu-link px-2">Contacto</a></li>
                                </ul>
                                <!--end::Menu-->    
                            </div>
                            <!--end::Footer-->                            
                        </div>
                        <!--end:::Main-->
                    </div>
                    <!--end::Wrapper container-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::App-->

        <!--begin::Drawer-->
        <div
            id="kt_drawer_ticket_nuevo"
            class="bg-white"
            data-kt-drawer="true"
            data-kt-drawer-activate="true"
            data-kt-drawer-toggle=".kt_drawer_ticket_nuevo_toggle"
            data-kt-drawer-close="#kt_drawer_ticket_nuevo_close"
            data-kt-drawer-overlay="true"
            data-kt-drawer-permanent="true"
            data-kt-drawer-width="{default:'100%', 'md': '600px'}"
        >
            <!--begin::Card-->
            <div class="card rounded-0 w-100">
                <!--begin::Card header-->
                <div class="card-header pe-5">
                    <!--begin::Title-->
                    <div class="card-title">
                        Nuevo Ticket
                    </div>
                    <!--end::Title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-light-danger" id="kt_drawer_ticket_nuevo_close">
                            <span>
                                <i class="ki-outline ki-cross-circle fs-2"></i>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body hover-scroll-overlay-y">
                    <form class="form" novalidate="novalidate" action="#" method="post" id="kt_ticket_nuevo_form">
                        <div class="row g-5 mb-5">
                            <div class="col-md-6 fv-row">
                                <label for="ticket_departamento" class="required form-label">Departamento</label>
                                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Selecciona una opción" id="ticket_departamento" name="ticket_departamento">
                                    <option></option>
                                </select>
                            </div>

                            <div class="col-md-6 fv-row">
                                <label for="ticket_tema" class="required form-label">Tema de ayuda</label>
                                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Selecciona una opción" id="ticket_tema" name="ticket_tema">
                                    <option></option>
                                </select>
                            </div>

                            <div class="col-md-12 fv-row">
                                <label for="ticket_sunto" class="required form-label">Asunto</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Motivo del ticket" id="ticket_sunto" name="ticket_sunto" maxlength="100"/>
                            </div>

                            <div class="col-md-12 fv-row">
                                <label for="ticket_detalle" class="required form-label">Detalle</label>
                                <div id="ticket_detalle" name="ticket_detalle" style="height: auto !important;"></div>
                            </div>
                        </div>
                    </form>

                    <!--begin::Input group-->
                    <div class="form-group row">
                        <!--begin::Label-->
                        <label class="col-md-12 col-form-label text-lg-right" for="kt_dropzonejs_ticket_nuevo">Archivos de evidencia</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-12">
                            <!--begin::Dropzone-->
                            <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_ticket_nuevo">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <a class="dropzone-select btn btn-sm btn-primary me-2">Agregar archivo</a>
                                    <a class="dropzone-upload btn btn-sm btn-light-primary me-2">Cargar todo</a>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-danger">Eliminar todo</a>
                                </div>
                                <!--end::Controls-->

                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">
                                    <div class="dropzone-item" style="display:none">
                                        <!--begin::File-->
                                        <div class="dropzone-file">
                                            <div class="dropzone-filename">
                                                <span data-dz-name>some_image_file_name.jpg</span>
                                                <strong>(<span data-dz-size>340kb</span>)</strong>
                                            </div>

                                            <div class="dropzone-error" data-dz-errormessage></div>
                                        </div>
                                        <!--end::File-->

                                        <!--begin::Progress-->
                                        <div class="dropzone-progress">
                                            <div class="progress">
                                                <div
                                                    class="progress-bar bg-primary"
                                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Progress-->

                                        <!--begin::Toolbar-->
                                        <div class="dropzone-toolbar">
                                            <!-- <span class="dropzone-start"><i class="bi bi-play-fill fs-3"></i></span> -->
                                            <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="bi bi-x fs-3"></i></span>
                                            <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->

                            <!--begin::Hint-->
                            <span class="form-text text-muted">
                                Haga clic para cargar los archivos de evidencia, máximo 5 archivos y 2MB por archivo.
                            </span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->

                <!-- begin::Card footer -->
                <div class="card-footer py-3">
                    <div class="d-grid col-md-8 mx-auto">
                        <button type="button" id="kt_registra_ticket" class="btn btn-dark">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">
                                Registrar Ticket
                            </span>
                            <!--end::Indicator label-->

                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">
                                Espere por favor...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                </div>
                <!-- end::Card footer -->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Drawer-->

        <!--begin::Drawer-->
        <div
            id="kt_drawer_ticket_detalle"
            class="bg-white"
            data-kt-drawer="true"
            data-kt-drawer-activate="true"
            data-kt-drawer-toggle=".kt_drawer_ticket_detalle_toggle"
            data-kt-drawer-close="#kt_drawer_ticket_detalle_close"
            data-kt-drawer-overlay="true"
            data-kt-drawer-permanent="true"
            data-kt-drawer-width="{default:'100%', 'md': '600px'}"
        >
            <!--begin::Card-->
            <div class="card rounded-0 w-100">
                <!--begin::Card header-->
                <div class="card-header pe-5">
                    <!--begin::Title-->
                    <div class="card-title">
                        Detalles del Ticket <span class="ms-2" id="lbl-ticket-detalle-folio">#0000</span>
                    </div>
                    <!--end::Title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-light-danger" id="kt_drawer_ticket_detalle_close">
                            <span>
                                <i class="ki-outline ki-cross-circle fs-2"></i>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body hover-scroll-overlay-y">
                    <form class="form" novalidate="novalidate" action="#" method="post" id="kt_ticket_detalle_form">
                        <div class="row g-5 mb-0">
                            <div class="col-md-6 fv-row">
                                <div class="rounded py-3 px-5 bg-light-secondary">
                                    <p class="form-label mb-0">Departamento</p>
                                    <span id="lbl-ticket-detalle-departamento"></span>
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <div class="rounded py-3 px-5 bg-light-secondary">
                                    <p class="form-label mb-0">Tema de ayuda</p>
                                    <span id="lbl-ticket-detalle-tema-ayuda"></span>
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <div class="rounded py-3 px-5 bg-light-secondary" id="lbl-ticket-detalle-prioridad">
                                    <div class="position-relative ps-6">
                                        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 sub-bg-color"></div>
                                        <a href="javascript:void(0);" class="mb-1 form-label sub-text">Prioridad</a>
                                        <div class="fs-7">El agente reevaluará este dato</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <div class="rounded py-3 px-5 bg-light-secondary">
                                    <div class="position-relative ps-6">
                                        <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div>
                                        <a href="javascript:void(0);" class="mb-1 form-label">Tiempo de espera</a>
                                        <div id="lbl-ticket-detalle-sla-espera">-</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 fv-row">
                                <div class="rounded py-3 px-5 bg-light-secondary">
                                    <div class="d-flex">
                                        <p class="form-label mb-0 me-auto">Asunto</p>
                                        <p class="form-label mb-0 fs-7" id="lbl-ticket-detalle-fecha">Creacion</p>
                                    </div>
                                    <span id="lbl-ticket-detalle-asunto"></span>
                                    <div id="ticket_detalle_detalle" style="height: auto !important;"></div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--begin::Input group-->
                    <div class="form-group row d-none" id="seccion-ticket-detalle-evidencia">
                        <!--begin::Label-->
                        <label class="col-md-12 col-form-label text-lg-right">Archivos de evidencia</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-12" id="contenedor-ticket-detalle-evidencia"></div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Drawer-->

        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <i class="ki-outline ki-arrow-up"></i>
        </div>
        <!--end::Scrolltop-->

        <!--begin::Javascript-->
        <script>
            var baseUrl = '<?= base_url() ?>';

            var localeFlatPickr = {
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
                rangeSeparator: " a "
            };
        </script>

        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
        <script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
        <script src="<?= base_url('assets/js/custom/cliente/general.js') ?>"></script>
        <!--end::Global Javascript Bundle-->

        <?php echo $this->renderSection('customScripts') ?>

        <!--end::Javascript-->
    </body>
</html>
