<?php
$title = ' - Enviar Mensagem';
$css = [
    "assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
    "assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css",
    "assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css",
    "assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css",
    "assets/plugins/toastr/toastr.min.css",
    
];
$script = [
    'assets/plugins/maskedinput/jquery.maskedinput.min.js',
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

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Mensagens</a></li>
                    <li class="breadcrumb-item active">Enviar Mensagem</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-paper-plane"></i> Enviar mensagem de texto </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row"> 

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Conexão</label>
                                    <select id="conexao" class="form-control">
                                        <?php foreach($response['conexoes'] as $item) {
                                            echo '<option value="'. $item['id'] .'">'. $item['nome'] .'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="tel" class="form-control telefone" id="telefone">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mensagem</label>
                                    <textarea id="mensagem" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-2" style="top: 30px;">
                                <button class="btn btn-success m-t-n-xs" type="submit"><strong>Enviar</strong></button>
                                <a href="javascript:history.back()" class="btn btn-default m-t-n-xs"><strong>Voltar</strong></a>
                            </div>        

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

$('.telefone').mask("(99) 9999-9999?9").focusout(function (event) {
    var target, phone, element;
    target = (event.currentTarget) ? event.currentTarget : event.srcElement;
    phone = target.value.replace(/\D/g, '');
    element = $(target);
    element.unmask();
    if(phone.length > 10) {
        element.mask("(99) 99999-999?9");
    } else {
        element.mask("(99) 9999-9999?9");
    }
});

$("button[type=submit").on('click', function(event){
    var conexao = $("#conexao").val();
    var telefone = $("#telefone").val();
    var mensagem = $("#mensagem").val();

    if(conexao == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Não é possivel enviar uma mensagem sem uma conexao.'
        })
    }

    if(telefone == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Não é possivel enviar uma mensagem sem o telefone.'
        })
    }

    if(mensagem == '') {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Não é possivel enviar uma mensagem vazia.'
        })
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
                        action: 'sendText',
                        param: {
                            conexao: conexao,
                            telefone: telefone,
                            mensagem: mensagem
                        }
                    },
                    cache: false,
                    success: function(result) {
                        if(result.status == 'sucesso') {
                            Swal.fire({
                                title: 'Legal!',
                                text: "Mensagem enviada com sucesso!",
                                icon: 'success'
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'Ops!',
                                text: 'Mensagem não enviada, tente novamente.',
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