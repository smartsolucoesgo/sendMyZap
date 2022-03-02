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



<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Chat-Bot</li>
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
                        <h3 class="card-title">Lista de Chat-Bot</h3>
                        <div class="card-tools">
                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#modal-add">Criar Chat-Bot</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Conexão</th>
                                    <th>Pergunta</th>
                                    <th>Resposta</th>
                                    <th width="50">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(@$response['chatbot'] as $item) {
                                    echo '<tr>';
                                    echo '<td>'. $item['conexao'] .'</td>';
                                    echo '<td>'. $item['pergunta'] .'</td>';
                                    echo '<td>'. $item['resposta'] .'</td>';
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

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Chat-Bot</h4>
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
                                    <label>Selecione uma Conexão</label>                                    
                                    <select name="id_conexao" id="id_conexao" class="form-control">
                                        <option value="">-- SELECIONE UMA CONEXÃO --</option>
                                        <?php foreach($response['conexoes'] as $item) {
                                            echo '<option value="'. $item['id'] .'">'. $item['nome'] .'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="pergunta" class="form-control"  placeholder="Informe uma pergunta que você quer que o bot responda">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="resposta" class="form-control"  placeholder="Informe a resposta que você quer dar ao ser feito a pergunta">
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

<div class="modal fade" id="modal-editar-chat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Chat-Bot</h4>
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
                                    <label>Selecione uma Conexão</label>
                                    <select name="editId_conexao" id="editId_conexao" class="form-control">
                                        <option value="">-- SELECIONE UMA CONEXÃO --</option>
                                        <?php foreach($response['conexoes'] as $item) {
                                            echo '<option value="'. $item['id'] .'">'. $item['nome'] .'</option>';
                                        } ?>
                                    </select>
                                    <script>$('select[name=editId_conexao]').val('')</script>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="editPergunta" class="form-control"  placeholder="Informe uma pergunta que você quer que o bot responda">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" id="editResposta" class="form-control"  placeholder="Informe a resposta que você quer dar ao ser feito a pergunta">
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



<script>

$("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "language": {
        url: "/assets/plugins/dataTables/i18n/Portuguese-Brasil.json"
    }
});

$("button[type=submit").on('click', function(event){
    event.preventDefault();

    var id_conexao = $("#id_conexao").val();
    var pergunta = $("#pergunta").val();
    var resposta = $("#resposta").val();  

    if(id_conexao == '') {
        Swal.fire({
            title: 'Ops!',
            text: "Você precisa informar qual a conexão esse chatbot pertence.",
            icon: 'error'
        })
        return false
    }  

    if(pergunta == '') {
        Swal.fire({
            title: 'Ops!',
            text: "Você precisa informar qual a pergunta.",
            icon: 'error'
        })
        return false
    }

    if(resposta == '') {
        Swal.fire({
            title: 'Ops!',
            text: "Você precisa informar qual a resposta.",
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
                        controller: 'Chatbot',
                        action: 'createAjax',
                        param: {
                            id_conexao: id_conexao,
                            pergunta: pergunta,
                            resposta: resposta
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

function editar(id) {
    $.getJSON("<?=URL_ADMIN?>/chatbot/consultaChat?id="+id+"", function(resultado){
        $("#modal-editar-chat").modal('show');
        $("#id").val(resultado.id);
        $("#editId_conexao").val(resultado.id_conexao);
        $("#editPergunta").val(resultado.pergunta);
        $("#editResposta").val(resultado.resposta);
    });
    
}

$("button[type=salvar").on('click', function(event){
    event.preventDefault();

    var id = $("#id").val();
    var id_conexao = $("#editId_conexao").val();
    var pergunta = $("#editPergunta").val();
    var resposta = $("#editResposta").val();
    

    if(id_conexao == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Você precisa informar uma conexão.'
        })
        return false
    }

    if(pergunta == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Você precisa informar uma pergunta.'
        })
        return false
    }

    if(resposta == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Você precisa informar uma resposta.'
        })
        return false
    }
    
    Swal.fire({
        title: 'Por favor aguarde',
        html: 'Processando os dados',
        timerProgressBar: false,
        didOpen: () => {
            Swal.showLoading()
            $("#modal-editar-chat").modal("hide");

            setTimeout(function () {
                $.ajax({
                    type: "POST",
                    url: '<?= URL_PUBLIC ?>/ajax',
                    dataType: 'json',
                    data: {
                        controller: 'Chatbot',
                        action: 'updateAjax',
                        param: {
                            id: id,
                            id_conexao: id_conexao,
                            pergunta: pergunta,
                            resposta: resposta
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
                        controller: 'Chatbot',
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