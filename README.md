Projeto realizado para integração com a api MyZap, projeto realizado em php puro no padrao MVC e OO. Bom uso

##############################################

Passo a passo para instalar:

primeiro suba seu MyZap em um servidor, caso não souber como instalar o MyZap de uma olhada aqui

https://github.com/billbarsch/myzap/blob/myzap2.0/manuais/instalacao_local_windows_ubuntu_wsl/MANUAL%20DE%20INSTALA%C3%87%C3%83O%20DO%20MYZAP%202.pdf

Ao subir o projeto sendMyZap em seu servidor, seja ele local ou na web, alterar os seguintes arquivos:

index.php na raiz do projeto na linha 6 onde está 'www' mudar para sua pasta de destino, exemplo: Wampserver onde foi utilizado o ambiente a pasta raiz é a www, em hospedagens constuma ser public_html entre outros.
na pasta app/application/config/config.php colocar as credenciais do seu banco de dados.

subir o banco de dados bd.sql que encontra na pasta app/application/config

feito isso é so usar.

email padrao: admin@myzap.com senha: 123

Agora é so ir em Configuracoes da Api, clicar em criar api e informar os dados do servidor do MyZap proximo passo e configurar a conexão, ler o qrcode, ai ja consegue enviar mensagem.

bom uso e faça um bom aproveito.