<?php
$title = ' - Painel de Controle';
$css = [
];
$script = [
];
$menuList = true;
require APP . 'view/admin/_templates/initFile.php';
?>

<div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
    <div class="nav-item dropdown">
        <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
            aria-expanded="false">Fechar</a>
        <div class="dropdown-menu mt-0">
            <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Fechar todos</a>
            <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Fechar todos os
                outros</a>
        </div>
    </div>

    <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
    <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
    <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
    <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>

    <a class="nav-link bg-primary" href="<?=URL_ADMIN?>/logout" role="button">Sair</a>

    

</div>
<div class="tab-content"></div>


<?php
require APP . 'view/admin/_templates/endFile.php';
?>