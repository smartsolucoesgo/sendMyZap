<?php
$title = ' - Lista de Api';
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

<style>
.MuiSvgIcon-root {
    fill: currentColor;
    width: 1em;
    height: 1em;
    display: inline-block;
    font-size: 1.5rem;
    transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    flex-shrink: 0;
    user-select: none;
}

.MuiSvgIcon-colorSecondary {
    color: #f50057;
}
</style>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Api</li>
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
                        <h3 class="card-title">Lista de Api</h3>
                        <div class="card-tools">
                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#modal-api">Criar Api</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Porta</th>
                                    <th>Token</th>
                                    <th>Webhook</th>
                                    <th>Status API</th>
                                    <th class="text-center">Ativo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($response as $item) {
                                    $connected = @fsockopen($item['url'], $item['porta']);
                                    if ($connected){
                                        fclose($connected);
                                        $icone = '<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="color: rgb(76, 175, 80);"><path d="M2 22h20V2z"></svg>';
                                        $tooltip = 'Online';
                                    }else{
                                        $icone = '<svg class="MuiSvgIcon-root MuiSvgIcon-colorSecondary" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path fill-opacity=".3" d="M22 8V2L2 22h16V8z"></path><path d="M14 22V10L2 22h12zm6-12v8h2v-8h-2zm0 12h2v-2h-2v2z"></path></svg>';
                                        $tooltip = 'Off-line';
                                    }
                                    echo '<tr>';
                                    echo '<td>'. $item['url'] .'</td>';
                                    echo '<td>'. $item['porta'] .'</td>';
                                    echo '<td>'. $item['apitoken'] .'</td>';
                                    echo '<td>'. $item['webhook'] .'</td>';
                                    echo '<td class="text-center" data-toggle="tooltip" title="'. $tooltip . '">'. $icone .'</td>';     
                                    if($item['status'] == 1) {
                                        echo '<td class="text-center"><a href="' . URL_ADMIN . '/api/inativar/' . $item['id'] . '"><i class="fa fa-solid fa-toggle-on"></i></a> Ativo</td>';
                                    } else {
                                        echo '<td class="text-center"><a href="' . URL_ADMIN . '/api/ativar/' . $item['id'] . '"><i class="fa fa-solid fa-toggle-off"></i></a> Inativo</td>';
                                    }
                                    echo '<td class="text-center">';
                                    echo '<a class="btn-xs btn-success" style="cursor:pointer;" onClick="editar('. $item['id'] .');"><i class="fa fa-pencil-alt"></i></a> | ';
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

<div class="modal fade" id="modal-api">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Api</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="protocol" id="protocol" class="form-control">
                                        <option value="http://">http</option>
                                        <option value="https://">https</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="padding-top: 5px;">
                                <div class="form-group">
                                    <label>Ativo</label>
                                    <input type="checkbox" name="my-checkbox" id="status" data-bootstrap-switch value="1">
                                </div>
                            </div>
                            
                            <hr>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name="url" id="url" class="form-control"  placeholder="URL do servidor da api (sem http/https)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="porta" id="porta" class="form-control"  placeholder="Porta do servidor">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="apitoken" id="apitoken" class="form-control"  placeholder="Token configurado no firebase">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="webhook" id="webhook" class="form-control"  placeholder="Webhook de resposta dos dados" value="<?=URL_PUBLIC?>/webhook" disabled>
                                </div>
                            </div>

                            <small>Caso não possua estas informações, entre em contato e solicite.</small>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar-api">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Api</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="editProtocol" id="editProtocol" class="form-control">
                                        <option value="http://">http</option>
                                        <option value="https://">https</option>
                                    </select>
                                    <script>$('select[name=editProtocol]').val('')</script>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" id="editUrl" class="form-control"  placeholder="URL do servidor da api (sem http/https)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="editPorta" class="form-control"  placeholder="Porta do servidor">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="editApitoken" class="form-control"  placeholder="Token configurado no firebase">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="editWebhook" class="form-control"  placeholder="Webhook de resposta dos dados" disabled>
                                </div>
                            </div>

                            <small>Caso não possua estas informações, entre em contato e solicite.</small>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" id="id">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="salvar" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

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
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
    

    $("button[type=submit").on('click', function(event){
        event.preventDefault();

        var checkbox = document.getElementById('status');

        if(checkbox.checked) {
            var status = 1;
        } else {
            var status = 0;
        }

        var protocol = $("#protocol").val();
        var url = $("#url").val();
        var porta = $("#porta").val();
        var apitoken = $("#apitoken").val();
        var webhook = $("#webhook").val();
        

        if(url == '') {
            Swal.fire({
                title: 'Ops!',
                text: "Você precisa informar a URL do servidor!",
                icon: 'error'
            })
            return false
        }

        if(porta == '') {
            Swal.fire({
                title: 'Ops!',
                text: "Você precisa informar a porta do servidor.",
                icon: 'error'
            })
            return false
        }
        
        Swal.fire({
            title: 'Por favor aguarde',
            html: 'Processando os dados',
            timerProgressBar: false,
            didOpen: () => {
                Swal.showLoading()

                setTimeout(function () {
                    $.ajax({
                        type: "POST",
                        url: '<?= URL_PUBLIC ?>/ajax',
                        dataType: 'json',
                        data: {
                            controller: 'Api',
                            action: 'createAjax',
                            param: {
                                status: status,
                                protocol: protocol,
                                url: url,
                                porta: porta,
                                apitoken: apitoken,
                                webhook: webhook
                            }
                        },
                        cache: false,
                        success: function(result) {
                            if(result.status == 'sucesso') {
                                $('#modal-api').modal('hide');
                                Swal.fire({
                                    title: 'Legal!',
                                    text: "Dados salvos com sucesso!",
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
        });
    });

});

function editar(id) {
    $.getJSON("<?=URL_ADMIN?>/api/consultaApi?id="+id+"", function(resultado){
        $("#modal-editar-api").modal('show');
        $("#id").val(resultado.id);
        $("#editProtocol").val(resultado.protocol);
        $("#editUrl").val(resultado.url);
        $("#editPorta").val(resultado.porta);
        $("#editApitoken").val(resultado.apitoken);
        $("#editWebhook").val(resultado.webhook);
    });
    
}

$("button[type=salvar").on('click', function(event){
    event.preventDefault();

    var id = $("#id").val();
    var protocol = $("#editProtocol").val();
    var url = $("#editUrl").val();
    var porta = $("#editPorta").val();
    var apitoken = $("#editApitoken").val();
    var webhook = $("#editWebhook").val();
    

    if(url == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Você precisa informar uma URL.'
        })
        return false
    }

    if(porta == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Você precisa informar a porta do servidor.'
        })
        return false
    }
    
    Swal.fire({
        title: 'Por favor aguarde',
        html: 'Processando os dados',
        timerProgressBar: false,
        didOpen: () => {
            Swal.showLoading()
            $("#modal-editar-api").modal("hide");

            setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: '<?= URL_PUBLIC ?>/ajax',
                    dataType: 'json',
                    data: {
                        controller: 'Api',
                        action: 'updateAjax',
                        param: {
                            id: id,
                            protocol: protocol,
                            url: url,
                            porta: porta,
                            apitoken: apitoken,
                            webhook: webhook
                        }
                    },
                    cache: false,
                    success: function(result) {
                        Swal.fire({
                            title: 'Legal!',
                            text: "Dados salvos com sucesso!",
                            icon: 'success'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
                    }
                });
            }, 1000);
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
                        controller: 'Api',
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