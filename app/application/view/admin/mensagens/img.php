<?php
$title = ' - Enviar Mensagem';
$css = [
    "assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
    "assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css",
    "assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css",
    "assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css",
    "assets/plugins/toastr/toastr.min.css",
    "assets/plugins/dropzone/min/dropzone.min.css"
    
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
    "assets/plugins/dropzone/min/dropzone.min.js"
];
require APP . 'view/admin/_templates/initFile.php';
?>

<div id="bloquear" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); z-index: 5000; display: none;">
    <div style="width: 200px; height: 100px; background-color: #ffffff; position:absolute; top: 50%; margin-top: -50px; left: 50%; margin-left: -100px; border-radius: 20px;">
        <br>
        <h2 class="text-center m-t-lg"><i class="fa fa-circle-notch fa-spin fa-lg"></i> <b>Aguarde</b></h2>
        <p class="text-center">Subindo imagem para envio.</p>
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
                    <li class="breadcrumb-item"><a href="<?=URL_ADMIN?>/mensagens">Mensagens</a></li>
                    <li class="breadcrumb-item active">Enviar Mensagem</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<form method="post" action="<?= URL_ADMIN . '/mensagens/imagem' ?>" autocomplete="off" enctype="multipart/form-data">
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
                                        <select id="conexao" name="conexao" class="form-control">
                                            <?php foreach($response['conexoes'] as $item) {
                                                echo '<option value="'. $item['id'] .'">'. $item['nome'] .'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="tel" name="telefone" class="form-control telefone" id="telefone">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mensagem</label>
                                        <textarea id="mensagem" name="mensagem" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Imagem</label>
                                        <input type="file" name="imagem" class="form-control" id="imagem" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-sm-2" style="top: 30px;">
                                    <button class="btn btn-success m-t-n-xs" type="enviar"><strong>Enviar</strong></button>
                                    <a href="javascript:history.back()" class="btn btn-default m-t-n-xs"><strong>Voltar</strong></a>
                                </div>  

                                <br><br><br><br>
                                    
                            </div>
                            <?php 
                            
                            if(@$response['sucesso']) {
                                echo '<p class="text-success"><strong>'.$response['sucesso'].'</strong></p>';
                            }

                            if(@$response['erro']) {
                                echo '<p class="text-success"><strong>'.$response['erro'].'</strong></p>';
                            }

                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

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

$("button[type=enviar").on('click', function(event){
    event.preventDefault();
    var conexao = $("#conexao").val();
    var telefone = $("#telefone").val();
    var mensagem = $("#mensagem").val();
    var imagem = $("#imagem").val();

    var envia = true;

    if(conexao == '') {
        var envia = false;
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
        var envia = false;
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

    if(imagem == '') {
        var envia = false;
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Não é possivel enviar uma mensagem sem a imagem.'
        })
    }

    if(envia == true) {
        $('#bloquear').detach().appendTo('body').fadeIn();
        $('form').submit();
    }

   
});


</script>

<?php
require APP . 'view/admin/_templates/endFile.php';
?>