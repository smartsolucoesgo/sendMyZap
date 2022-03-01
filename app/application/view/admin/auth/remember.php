<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?= URL_ADMIN ?>" target="_self">
        <title><?= APP_TITLE ?></title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/" class="h3"><?= APP_TITLE ?></a>
                </div>
                <div class="card-body">
                    <?php if($response['id'] == '') { ?>
                        <p class="login-box-msg">Ops, link usado ou vencido, caso ainda precise solicite um novo.</p>
                    <?php } else { ?>
                        <p class="login-box-msg">Você está a apenas um passo de sua nova senha, recupere sua senha agora.</p>
                        <form role="form" method="post" action="<?= URL_ADMIN ?>/newpassword" id="form">
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="senha" id="senha" autocomplete="off" placeholder="Insira sua nova senha" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="senha2" autocomplete="off" placeholder="Repita sua nova senha" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <?php if(@$response['erro']) echo '<p style="color: red;">' . $response['erro'] . '</p>';  ?>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block salvar">Alterar</button>
                                </div>
                            </div>                        
                        </form>
                    <?php } ?>
                    <p class="mb-1">
                        <a href="<?= URL_PUBLIC ?>">Entrar</a>
                    </p>
                </div>
            </div>
        </div> 

        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/dist/js/adminlte.min.js"></script>       
        
        <script>
            $('button[type=submit').on('click', function(event){

                var senha = $("#senha").val();
                var senha2 = $("#senha2").val();

                if(senha == '') {
                    alert('Favor, insira uma nova senha');
                    return false
                }

                if(senha2 == '') {
                    alert('Favor, repita a nova senha');
                    return false
                }

                if(senha != senha2) {
                    alert('Favor, as senhas precisam ser iguais');
                    return false
                }

                $('.salvar').prop('disabled',true);
                
                document.getElementById("form").submit();
            });
        </script>
    </body>
</html>