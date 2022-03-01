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
                    <p class="login-box-msg">Você esqueceu sua senha? Aqui você pode facilmente recuperar uma nova senha.</p>
                    <form role="form" method="post" action="<?= URL_ADMIN ?>/forgot" id="form">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Insira seu e-mail" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <?php if(@$response['erro']) echo '<p style="color: red;">' . $response['erro'] . '</p>';  ?>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block salvar">Solicitar</button>
                            </div>
                        </div>                        
                    </form>
                    <?php if(@$response['email']) echo '<p style="color: green;">' . $response['email'] . '</p>';  ?>
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

                var email = $("#email").val();

                if(email == '') {
                    alert('Favor, informe seu e-mail');
                    return false
                }

                $('.salvar').prop('disabled',true);
                
                document.getElementById("form").submit();
            });
        </script>
    </body>
</html>