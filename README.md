# SendMyZAP

Projeto realizado para integração com a API do MyZap, projeto realizado em php puro no padrão MVC e OO.

# Passo a passo para instalar:

Primeiro suba seu MyZap em um servidor, caso não souber como instalar o MyZap de uma olhada aqui

https://apigratis.com.br/static/downloads/MANUAL-DE-INSTALACAO-DO-MYZAP-2.pdf

# Apos a instalação
Ao subir o projeto sendMyZap em seu servidor, seja ele local ou na web, alterar os seguintes arquivos:

```index.php``` na raiz do projeto na linha 6 onde está 'www' mudar para sua pasta de destino, exemplo: Wampserver onde foi utilizado o ambiente a pasta raiz é a www, em hospedagens constuma ser public_html entre outros.
na pasta app/application/config/config.php colocar as credenciais do seu banco de dados.

Subir o banco de dados ```bd.sql``` que encontra na pasta ```app/application/config```

# Feito isso é so usar.

Usuário: admin@myzap.com

Senha: 123

Agora é so ir em Configuracoes da Api, clicar em criar api e informar os dados do servidor do MyZap proximo passo e configurar a conexão, ler o qrcode, ai ja consegue enviar mensagem.

Bom uso e faça um bom aproveito.
