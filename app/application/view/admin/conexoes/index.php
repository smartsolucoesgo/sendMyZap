<?php
$title = ' - Lista de Conexões';
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
    "assets/plugins/toastr/toastr.min.js",
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
</style>

<div id="qrcode" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); z-index: 5000; display: none;">
    <div style="width: 250px; height: 100px; background-color: #ffffff; position:absolute; top: 50%; margin-top: -50px; left: 50%; margin-left: -100px; border-radius: 20px;">
        <br>
        <h2 class="text-center m-t-lg"><i class="fas fa-circle-notch fa-spin fa-lg"></i> <b>Aguarde</b></h2>
        <p class="text-center">Estamos comunicando com a API.</p>
    </div>
</div>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=URL_ADMIN?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Conexões</li>
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
                        <h3 class="card-title">Lista de Conexões</h3>
                        <div class="card-tools">
                            <?php if($response['conexoes'] == null) { ?>
                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#modal-conexao">Criar Conexão</button>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="350">Nome</th>
                                    <th class="text-center" width="350">API</th>
                                    <th class="text-center" width="50">Status</th>
                                    <th class="text-center" width="50">Sessão</th>
                                    <th class="text-center" width="100">Última Atualização</th>
                                    <th class="text-center" width="50">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($response['conexoes'] as $item) {
                                    echo '<tr>';
                                    echo '<td>'. $item['nome'] .'</td>';
                                    echo '<td>'. $item['api'] .'</td>';
                                    switch ($item['conn']) {
                                        case 0: 
                                            $status = '<button type="qrcode" class="btn btn-success btn-xs qrcode" data-id="'. $item['id'] .'"><strong>QR CODE</strong></button>';
                                            $style = '';
                                            $icone = '<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5v4h2V5h4V3H5c-1.1 0-2 .9-2 2zm2 10H3v4c0 1.1.9 2 2 2h4v-2H5v-4zm14 4h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4zm0-16h-4v2h4v4h2V5c0-1.1-.9-2-2-2z" style="height: 25px;"></svg>';
                                            $tooltip = 'Esperando leitura do QR Code, clique no botao QR CODE e leia o QR Code com o seu celular para iniciar a sessão';
                                            break;
                                        case 1: 
                                            $status = '<button type="desconectar" class="btn btn-danger btn-xs desconectar" data-id="'. $item['id'] .'"><strong>DESCONECTAR</strong></button>';
                                            $style = 'text-success';
                                            $icone = '<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true" style="color: rgb(76, 175, 80);"><path d="M2 22h20V2z"></svg>';
                                            $tooltip = 'Conexão Estabelecida';
                                            break;
                                    }
                                    echo '<td class="text-center" data-toggle="tooltip" title="'. $tooltip . '">'. $icone .'</td>';
                                    echo '<td class="text-center '. $style .'" id="online'.$item['id'].'">'. $status .'</td>';
                                    
                                    if($item['data_alteracao'] == '') {
                                        echo '<td class="text-center">Sem Atualização</td>';
                                    } else {
                                        echo '<td class="text-center">'. \SmartSolucoes\Libs\Helper::dataHora($item['data_alteracao']) .'</td>';
                                    }                                    
                                    echo '<td class="text-center">';
                                    if($item['conn'] == 1) {
                                        echo '<a class="btn-xs btn-success" style="cursor:pointer;" data-toggle="tooltip" title="Editar" onClick="naoEditar()"><i class="fa fa-pencil-alt"></i></a> | ';
                                    } else {
                                        echo '<a class="btn-xs btn-success" style="cursor:pointer;" data-toggle="tooltip" title="Editar" onClick="editar('. $item['id'] .')"><i class="fa fa-pencil-alt"></i></a> | ';
                                    }
                                    echo '<a class="btn-xs btn-danger" style="cursor:pointer;" data-toggle="tooltip" title="Excluir" onClick="apagar('. $item['id'] .')"><i class="fa fa-trash-alt"></i></a>';
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



<div class="modal fade" id="modal-conexao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar WhatsApp</h4>
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
                                    <input type="text" id="nome" class="form-control" placeholder="Nome da conexão">
                                </div>
                            </div>

                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="id_api" id="id_api" class="form-control">
                                        <option value="">Selecione uma API</option>
                                        <?php foreach($response['api'] as $api) {
                                            echo '<option value="'. $api['id'] .'">'. $api['url'] .'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

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

<div class="modal fade" id="modal-editar-conexao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Conexão WhatsApp</h4>
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
                                    <input type="text" id="nomeCon" class="form-control" placeholder="Nome da conexão">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select id="id_api_edit" class="form-control">
                                        <option value="">Selecione uma API</option>
                                        <?php foreach($response['api'] as $api) {
                                            echo '<option value="'. $api['id'] .'">'. $api['url'] .'</option>';
                                        } ?>
                                    </select>
                                    <script>$('select[name=id_api_edit]').val('')</script>
                                </div>
                            </div>

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

<div class="modal fade" id="modal-qrcode" style="padding: 90px 16px 90px 90px;">
    <div class="modal-dialog" style="left: 151px;">
        <div class="modal-content" style="width: 65%;">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                            
                        <div class="col-md-12">
                            <p>Leia o QrCode para iniciar a sessão</p>
                            <img src="" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){

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

        var nome = $("#nome").val();
        var id_api = $("#id_api").val();
        

        if(nome == '') {
            Swal.fire({
                title: 'Ops!',
                text: "Você precisa informar um nome para a conexão!",
                icon: 'error'
            })
            return false
        }

        if(id_api == '') {
            Swal.fire({
                title: 'Ops!',
                text: "Você precisa escolher uma API!",
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
                            controller: 'Conexoes',
                            action: 'createAjax',
                            param: {
                                nome: nome,
                                id_api: id_api,
                                mensagem_saudacao: mensagem_saudacao,
                                mensagem_despedida: mensagem_despedida
                            }
                        },
                        cache: false,
                        success: function(result) {
                            if(result.status == 'sucesso') {
                                $('#modal-conexao').modal('hide');
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
    $.getJSON("<?=URL_ADMIN?>/conexoes/consultaConexao?id="+id+"", function(resultado){
        $("#modal-editar-conexao").modal("show");
        $("#id").val(resultado.id);
        $("#nomeCon").val(resultado.nome);
        $("#id_api_edit").val(resultado.id_api);
    });
}

function naoEditar() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        icon: 'error',
        title: 'Não é possivel editar uma conexão ativa.'
    })
}

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
                        controller: 'Conexoes',
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

$('button[type=qrcode').on('click', function(event){
    var id = $('.qrcode').attr('data-id');
    $('#qrcode').fadeIn();

    setTimeout(function () {
        $.ajax({
            type: "POST",
            url: '<?= URL_PUBLIC ?>/ajax',
            dataType: 'json',
            data: {
                controller: 'Api',
                action: 'session',
                param: {
                    id: id
                }
            },
            cache: false,
            success: function(result) {
                if(result.status == 'sucesso') {

                    setInterval(function() {
                        $.getJSON("<?=URL_ADMIN?>/conexoes/consultaConexao?id="+id+"", function(result){
                            if(result.conn == 0) {
                                if(result.qrcode != null) {
                                    console.log(result)
                                    $('#qrcode').fadeOut();
                                    $("#modal-qrcode img").attr("src", result.qrcode);
                                    $("#modal-qrcode").modal("show");
                                    setInterval(function() {
                                        $.getJSON("<?=URL_ADMIN?>/conexoes/consultaConexao?id="+id+"", function(resultado){
                                            if(resultado.conn == 1) {
                                                $("#modal-qrcode").modal("hide");
                                                window.location.reload();
                                            }
                                            console.log('vendo se foi conectado')
                                        });
                                    }, 2000);
                                }
                            } else {
                                console.log('conectado');
                                console.log(result.conn);
                            }

                        });
                        //console.log('funcionou');
                    }, 3000); //3 segundos

                } else if(result.status == 'falha') {
                    $('#qrcode').fadeOut();
                    Swal.fire({
                        title: 'Ops!',
                        text: "Falha na comunicação com a API!",
                        icon: 'error'
                    })
                    return false
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
});

$("button[type=salvar").on('click', function(event){
    event.preventDefault();

    var id = $("#id").val();
    var nome = $("#nomeCon").val();
    var id_api = $("#id_api_edit").val();

    Swal.fire({
        title: 'Por favor aguarde',
        html: 'Processando os dados',
        timerProgressBar: false,
        didOpen: () => {
            Swal.showLoading()
            $("#modal-editar-conexao").modal("hide");

            setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: '<?= URL_PUBLIC ?>/ajax',
                    dataType: 'json',
                    data: {
                        controller: 'Conexoes',
                        action: 'updateAjax',
                        param: {
                            id: id,
                            nome: nome,
                            id_api: id_api
                        }
                    },
                    cache: false,
                    success: function(result) {
                        if(result.status == 'sucesso') {
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
                    }
                });
            }, 1000);
        }
    });

});

$("button[type=desconectar").on('click', function(event){
    var id = $('.desconectar').attr('data-id');

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
                        action: 'closeConnectionAjax',
                        param: {
                            id: id
                        }
                    },
                    cache: false,
                    success: function(result) {
                        if(result.status == 'desconectado') {

                            setInterval(function() {
                                $.getJSON("<?=URL_ADMIN?>/conexoes/consultaConexao?id="+id+"", function(resultado){
                                    if(resultado.conn == 0) {
                                        
                                        window.location.reload();
                                    }
                                });
                            }, 2000);
                        } else if(result.status == 'erro'){
                            Swal.fire({
                                title: 'Ops!',
                                text: result.mensagem,
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


</script>


<?php
require APP . 'view/admin/_templates/endFile.php';
?>