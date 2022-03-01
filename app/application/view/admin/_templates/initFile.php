<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_TITLE . $title?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

    <?php
    foreach ($css as $file) {
        if(file_exists($file)) {
            echo '<link href="/' . $file . '" rel="stylesheet">';
        }
    }
    ?>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <?php
    foreach ($script as $file) {
        if(file_exists($file)) {
            echo '<script src="/' . $file . '"></script>';
        }
    }
    ?>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=URL_ADMIN?>" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <!-- <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> -->
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Você não possui mensagens</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="notifie">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifieBody">
          <!-- <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a> -->
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Você não possui notificações</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-cogs"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=URL_ADMIN?>/logout" role="button">
          <i class="fas fa-sign-out-alt"></i> Sair
        </a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/<?=$_SESSION['imagem']?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?=URL_ADMIN?>/account" class="d-block"><?=$_SESSION['nome']?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item" >
            <a href="/" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'inicio') !== false) {echo 'active';} ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard </p>
            </a>
          </li>

          <li class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'mensagens') !== false) {echo 'menu-open';} ?>">
            <a href="#" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'mensagens') !== false) {echo 'active';} ?>"><i class="nav-icon fab fa-whatsapp">
              </i><p> Enviar Mensagens <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=URL_ADMIN?>/mensagens/texto" class="nav-link <?php if(URL_PUBLIC.$_SERVER['REQUEST_URI'] == URL_ADMIN.'/mensagens/texto') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i><p>Texto</p></a>
              </li>
              <li class="nav-item">
                <a href="<?=URL_ADMIN?>/mensagens/imagem" class="nav-link <?php if(URL_PUBLIC.$_SERVER['REQUEST_URI'] == URL_ADMIN.'/mensagens/imagem') { echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i><p>Imagem</p></a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?=URL_ADMIN?>/usuario" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'usuario') !== false) {echo 'active';} ?>">
              <i class="nav-icon fas fa-users"></i>
                <p>Usuários </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=URL_ADMIN?>/conexoes" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'conexoes') !== false) {echo 'active';} ?>">
              <i class="nav-icon fas fa-link"></i>
                <p>Conexões </p>
            </a>
          </li>
          <li class="nav-item" >
            <a href="<?=URL_ADMIN?>/api" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'api') !== false) {echo 'active';} ?>">
              <i class="nav-icon fas fa-laptop-code"></i>
                <p>Configurações da API </p>
            </a>
          </li>
          <li class="nav-item" >
            <a href="<?=URL_ADMIN?>/configuracoes" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'configuracoes') !== false) {echo 'active';} ?>">
              <i class="nav-icon fas fa-cogs"></i>
                <p>Configurações do Sistema </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content">
        <p>Configurações Personalizadas</p><hr class="mb-2"/>
        <div class="mb-4">
            <input type="checkbox" id="dark"> <span>Dark Mode</span>
        </div>
        <div class="mb-4">
            <input type="checkbox" id="text"> <span>Letras Pequenas</span>
        </div>
    </div>
  </aside>

  <div class="content-wrapper">
