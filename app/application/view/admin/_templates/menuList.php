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
                <li
                    class="nav-item <?php if (stripos($_SERVER['REQUEST_URI'],'mensagens') !== false) {echo 'menu-open';} ?>">
                    <a href="#"
                        class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'mensagens') !== false) {echo 'active';} ?>"><i
                            class="nav-icon fab fa-whatsapp">
                        </i>
                        <p> Enviar Mensagens <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=URL_ADMIN?>/mensagens/texto"
                                class="nav-link <?php if(URL_PUBLIC.$_SERVER['REQUEST_URI'] == URL_ADMIN.'/mensagens/texto') { echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Texto</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=URL_ADMIN?>/mensagens/imagem"
                                class="nav-link <?php if(URL_PUBLIC.$_SERVER['REQUEST_URI'] == URL_ADMIN.'/mensagens/imagem') { echo 'active'; } ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Imagem</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?=URL_ADMIN?>/chatbot"
                        class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'chatbot') !== false) {echo 'active';} ?>">
                        <i class="nav-icon fas fa-robot"></i>
                        <p>Chat-Bot </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=URL_ADMIN?>/usuario"
                        class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'usuario') !== false) {echo 'active';} ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Usuários </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=URL_ADMIN?>/conexoes"
                        class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'conexoes') !== false) {echo 'active';} ?>">
                        <i class="nav-icon fas fa-link"></i>
                        <p>Conexões </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=URL_ADMIN?>/api"
                        class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'api') !== false) {echo 'active';} ?>">
                        <i class="nav-icon fas fa-laptop-code"></i>
                        <p>Configurações da API </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=URL_ADMIN?>/configuracoes"
                        class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'],'configuracoes') !== false) {echo 'active';} ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Configurações do Sistema </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>