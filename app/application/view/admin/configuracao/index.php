<?php
$title = ' - Configurações do Sistema';
$css = [
    '',
];
$script = [
	'',
];
require APP . 'view/admin/_templates/initFile.php';
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Configurações do Sistema</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalhes</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nome do Sistema</th>
                                    <th>Situação</th>
                                    <th>Protocolo</th>
                                    <th class="text-center" width="150">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ((array)$response as $config) {
                                        echo '<tr>';
                                        echo '<td>' . $config['app_title'] . '</td>';
                                        echo '<td>' . $config['environment'] . '</td>';
                                        echo '<td>' . $config['protocol'] . '</td>';
                                        echo '<td class="text-center"><a class="btn-xs btn-success" href="' . URL_ADMIN . '/configuracoes/editar/'. $config['id'] . '"><i class="fa fa-pencil-alt"></i> Editar Informações</a> </td>';
                                        echo '</tr>';
                                    } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require APP . 'view/admin/_templates/endFile.php';
?>