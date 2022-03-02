<?php
$title = ' - Lista de Usuários';
$css = [
    "assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
    "assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css",
    "assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css",
    "assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css",
    "assets/plugins/toastr/toastr.min.css",
    
];
$script = [
    "assets/plugins/datatables/jquery.dataTables.min.js",
    "assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
    "assets/plugins/datatables-responsive/js/dataTables.responsive.min.js",
    "assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
    "assets/plugins/datatables-buttons/js/dataTables.buttons.min.js",
    "assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
    "assets/plugins/jszip/jszip.min.js",
    "assets/plugins/pdfmake/pdfmake.min.js",
    "assets/plugins/pdfmake/vfs_fonts.js",
    "assets/plugins/datatables-buttons/js/buttons.html5.min.js",
    "assets/plugins/datatables-buttons/js/buttons.print.min.js",
    "assets/plugins/datatables-buttons/js/buttons.colVis.min.js",
    "assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
    "assets/plugins/sweetalert2/sweetalert2.min.js",
    "assets/plugins/toastr/toastr.min.js"
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
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Usuários</h3>
                        <div class="card-tools">
                            <a href="<?=URL_ADMIN?>/usuario/novo" class="btn btn-outline-primary btn-sm">Criar Usuário</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th class="text-center">Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($response as $item) {
                                    echo '<tr>';
                                    echo '<td>'. $item['nome'] .'</td>';
                                    echo '<td>'. $item['telefone'] .'</td>';
                                    echo '<td>'. $item['email'] .'</td>';  
                                    if($item['status'] == 1) {
                                        echo '<td class="text-center"><a href="' . URL_ADMIN . '/usuario/inativar/' . $item['id'] . '"><i class="fa fa-solid fa-toggle-on"></i></a> Ativo</td>';
                                    } else {
                                        echo '<td class="text-center"><a href="' . URL_ADMIN . '/usuario/ativar/' . $item['id'] . '"><i class="fa fa-solid fa-toggle-off"></i></a> Inativo</td>';
                                    }
                                    echo '<td class="text-center">';
                                    echo '<a class="btn-xs btn-success" href="' . URL_ADMIN . '/usuario/editar/' . $item['id'] . '"><i class="fa fa-pencil-alt"></i></a> | ';
                                    echo '<a class="btn-xs btn-danger" style="cursor:pointer;" onClick="apagar('. $item['id'] .')"><i class="fa fa-trash-alt"></i></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>



<script>

$(function() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "language": {
            url: "/assets/plugins/dataTables/i18n/Portuguese-Brasil.json"
        }
    });

});

function apagar(id) {
    Swal.fire({
        title: 'Deseja realmente excluir ?',
        text: "Essa ação pode ser irreversivél!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, eu quero excluir!',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: '<?= URL_PUBLIC ?>/ajax',
                    dataType: 'json',
                    data: {
                        controller: 'User',
                        action: 'deleteAjax',
                        param: {
                            id: id
                        }
                    },
                    cache: false,
                    success: function(result) {
                        if(result.status == 'sucesso') {
                            Swal.fire({
                                title: 'Legal!',
                                text: "Dados apagados com sucesso!",
                                icon: 'success'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'Ops!',
                                text: "Algo deu errado, tente novamente!",
                                icon: 'error'
                            })
                            return false
                        }
                    }
                });
            }, 1000);
        }
    })
}

</script>

<?php
require APP . 'view/admin/_templates/endFile.php';
?>
