<?php
$title = 'Editar meus dados';
$css = [
    '',
];
$script = [
    'assets/plugins/maskedinput/jquery.maskedinput.min.js',
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
                    <li class="breadcrumb-item"><a href="<?=URL_ADMIN?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?=URL_ADMIN?>/usuario">Usuários</a></li>
                    <li class="breadcrumb-item active">Meus Dados</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user"></i> <?= isset($response['nome']) ? 'Editar Meus Dados' : 'Novo usuário' ?> </h3>
            </div>
            <div class="card-body">
                <form role="form" method="post" action="<?= URL_ADMIN ?>/account/save" autocomplete="off" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row"> 

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" value="<?= isset($response['nome']) ? $response['nome'] : '' ?>">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="<?= isset($response['email']) ? $response['email'] : '' ?>">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" class="form-control" name="senha" value="">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="tel" class="form-control telefone" name="telefone" value="<?= isset($response['telefone']) ? $response['telefone'] : '' ?>">
                                    </div>
                                </div>

                                

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto</label>
                                                <input type="file" name="imagem" placeholder="" class="form-control" value="" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if(isset($response['imagem']) && $response['imagem']) {
                                                ?>
                                                <div class="user-image" style="background-image: url('<?= $response['imagem']?>');">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2" style="top: 30px;">
                                    <input type="hidden" name="id" value="<?= isset($response['id']) ? $response['id'] : '' ?>">
                                    <button class="btn btn-success m-t-n-xs" type="submit"><strong>Salvar</strong></button>
                                    <a href="javascript:history.back()" class="btn btn-default m-t-n-xs"><strong>Voltar</strong></a>
                                </div>        

                            </div>
                        </div>
                    </div>
                </form>
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
</script>

<?php
require APP . 'view/admin/_templates/endFile.php';
?>
