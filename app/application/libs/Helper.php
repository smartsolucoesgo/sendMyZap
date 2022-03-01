<?php
namespace SmartSolucoes\Libs;

use SmartSolucoes\Libs\Upload;
use SmartSolucoes\Core\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Helper
{

    static public function splitUrl()
    {
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    static public function view($view, $response = [])
    {
        if(!$view) {
            $view = 'error/index';
        }
        require APP . 'view/' . $view . '.php';
    }

    static public function ajax($nomecontroller,$action,$param)
    {
        $getController = '\SmartSolucoes\Controller\\'.$nomecontroller.'Controller';
        $controller = New $getController();
        $controller->{$action}($param);
    }

    static public function upload($arquivo,$nome_arquivo,$caminho,$formato=false,$largura=false,$altura=false,$ratio=true)
    {
        $foo = new Upload($arquivo);
        if ($foo->uploaded) {
            $foo->file_overwrite = true;
            $foo->file_new_name_body = $nome_arquivo;
            if($largura) {
                $foo->image_convert = $formato;
            }
            if($largura) {
                $foo->image_resize = true;
                $foo->image_ratio = $ratio;
                $foo->image_x = $largura;
                $foo->image_y = $altura;
            }
            $foo->Process($caminho);
            if ($foo->processed) {
                $foo->Clean();
                return true;
            } else {
//                return $foo->error;
                return false;
            }
        } else {
//            return $foo->error;
            return false;
        }
    }

    static public function rearrange( $arr ){
        foreach( $arr as $key => $all ){
            foreach( $all as $i => $val ){
                $new[$i][$key] = $val;
            }
        }
        return $new;
    }

    static public function iconFile($file){
        $file = explode('.',$file);
        $ext = end($file);
        switch ($ext){
            case 'doc':
            case 'docx':
                $icon = 'fa fa-file-word-o';
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                $icon = 'fa fa-file-excel-o';
                break;
            case 'ppt':
            case 'pptx':
                $icon = 'fa fa-file-powerpoint-o';
                break;
            case 'pdf':
                $icon = 'fa fa-file-pdf-o';
                break;
            case 'psd':
            case 'cdr':
            case 'ai':
            case 'bmp':
            case 'gif':
            case 'jpeg':
            case 'jpg':
            case 'png':
                $icon = 'fa fa-file-image-o';
                break;
            case 'zip':
            case 'rar':
            case '7z':
                $icon = 'fa fa-file-archive-o';
                break;
            case 'mp3':
            case 'wma':
            case 'aac':
            case 'ogg':
            case 'ac3':
            case 'wav':
                $icon = 'fa fa-file-audio-o';
                break;
            case 'mpeg':
            case 'mov':
            case 'avi':
            case 'rmvb':
            case 'mkv':
            case 'mxf':
            case 'pr':
                $icon = 'fa fa-file-movie-o';
                break;
            case 'txt':
                $icon = 'fa fa-file-text-o';
                break;
            case 'php':
            case 'html':
            case 'css':
            case 'js':
                $icon = 'fa fa-file-code-o';
                break;
            default:
                $icon = 'fa fa-file-o';
                break;
        }
        return $icon;
    }

    static public function dataHora($data,$gravar=false) {
        if($gravar) {
            $data = str_replace('/', '-', $data);
            $data = date('Y-m-d H:i:s',strtotime($data));
        } else {
            $data = date('d/m/Y H:i',strtotime($data));
        }

        return $data;
    }

    static public function data($data,$gravar=false) {
        if($data) {
            if($gravar) {
                $data = str_replace('/', '-', $data);
                $data = date('Y-m-d',strtotime($data));
            } else {
                $data = date('d/m/Y',strtotime($data));
            }
        }
        return $data;
    }

    static public function hora($hora) {
        $hora = substr($hora,0,-3);
        return $hora;
    }

    static public function valor($valor,$gravar = false) {
        if($gravar) {
            $valor = str_replace(',','.',str_replace(['.','R$',' '],'',$valor));
        } else {
            $valor = number_format($valor,2,',','.');
        }
        return $valor;
    }

    static public function cleanToUrl($valor)
    {
        return mb_strtolower(str_replace(" ","+",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($valor)))));
    }

    static public function trataMail($param)
    {
        switch($param['tipo']) {
            case 'forgot':
                $mensagem  = '<a href="'. URL_PUBLIC .'/remember/'.$param['session'].'">Clique aqui para redefinr</a>';
                self::mail('Redefinir Senha',$mensagem,[$param['email']]);
                break;
        }
    }

    static public function mail($assunto, $msg, $email = [], $cc = false, $anexo = false)
    {
      $body = '<!doctype html>
      <html>
        <head>
          <meta name="viewport" content="width=device-width" />
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <title>Redefinir Senha</title>
          <style>
            /* -------------------------------------
                GLOBAL RESETS
            ------------------------------------- */
            
            /*All the styling goes here*/
            
            img {
              border: none;
              -ms-interpolation-mode: bicubic;
              max-width: 100%; 
            }
      
            body {
              background-color: #f6f6f6;
              font-family: sans-serif;
              -webkit-font-smoothing: antialiased;
              font-size: 14px;
              line-height: 1.4;
              margin: 0;
              padding: 0;
              -ms-text-size-adjust: 100%;
              -webkit-text-size-adjust: 100%; 
            }
      
            table {
              border-collapse: separate;
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
              width: 100%; }
              table td {
                font-family: sans-serif;
                font-size: 14px;
                vertical-align: top; 
            }
      
            /* -------------------------------------
                BODY & CONTAINER
            ------------------------------------- */
      
            .body {
              background-color: #f6f6f6;
              width: 100%; 
            }
      
            /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
            .container {
              display: block;
              margin: 0 auto !important;
              /* makes it centered */
              max-width: 580px;
              padding: 10px;
              width: 580px; 
            }
      
            /* This should also be a block element, so that it will fill 100% of the .container */
            .content {
              box-sizing: border-box;
              display: block;
              margin: 0 auto;
              max-width: 580px;
              padding: 10px; 
            }
      
            /* -------------------------------------
                HEADER, FOOTER, MAIN
            ------------------------------------- */
            .main {
              background: #ffffff;
              border-radius: 3px;
              width: 100%; 
            }
      
            .wrapper {
              box-sizing: border-box;
              padding: 20px; 
            }
      
            .content-block {
              padding-bottom: 10px;
              padding-top: 10px;
            }
      
            .footer {
              clear: both;
              margin-top: 10px;
              text-align: center;
              width: 100%; 
            }
              .footer td,
              .footer p,
              .footer span,
              .footer a {
                color: #999999;
                font-size: 12px;
                text-align: center; 
            }
      
            /* -------------------------------------
                TYPOGRAPHY
            ------------------------------------- */
            h1,
            h2,
            h3,
            h4 {
              color: #000000;
              font-family: sans-serif;
              font-weight: 400;
              line-height: 1.4;
              margin: 0;
              margin-bottom: 30px; 
            }
      
            h1 {
              font-size: 35px;
              font-weight: 300;
              text-align: center;
              text-transform: capitalize; 
            }
      
            p,
            ul,
            ol {
              font-family: sans-serif;
              font-size: 14px;
              font-weight: normal;
              margin: 0;
              margin-bottom: 15px; 
            }
              p li,
              ul li,
              ol li {
                list-style-position: inside;
                margin-left: 5px; 
            }
      
            a {
              color: #3498db;
              text-decoration: underline; 
            }
      
            /* -------------------------------------
                BUTTONS
            ------------------------------------- */
            .btn {
              box-sizing: border-box;
              width: 100%; }
              .btn > tbody > tr > td {
                padding-bottom: 15px; }
              .btn table {
                width: auto; 
            }
              .btn table td {
                background-color: #ffffff;
                border-radius: 5px;
                text-align: center; 
            }
              .btn a {
                background-color: #ffffff;
                border: solid 1px #3498db;
                border-radius: 5px;
                box-sizing: border-box;
                color: #3498db;
                cursor: pointer;
                display: inline-block;
                font-size: 14px;
                font-weight: bold;
                margin: 0;
                padding: 12px 25px;
                text-decoration: none;
                text-transform: capitalize; 
            }
      
            .btn-primary table td {
              background-color: #3498db; 
            }
      
            .btn-primary a {
              background-color: #3498db;
              border-color: #3498db;
              color: #ffffff; 
            }
      
            /* -------------------------------------
                OTHER STYLES THAT MIGHT BE USEFUL
            ------------------------------------- */
            .last {
              margin-bottom: 0; 
            }
      
            .first {
              margin-top: 0; 
            }
      
            .align-center {
              text-align: center; 
            }
      
            .align-right {
              text-align: right; 
            }
      
            .align-left {
              text-align: left; 
            }
      
            .clear {
              clear: both; 
            }
      
            .mt0 {
              margin-top: 0; 
            }
      
            .mb0 {
              margin-bottom: 0; 
            }
      
            .preheader {
              color: transparent;
              display: none;
              height: 0;
              max-height: 0;
              max-width: 0;
              opacity: 0;
              overflow: hidden;
              mso-hide: all;
              visibility: hidden;
              width: 0; 
            }
      
            .powered-by a {
              text-decoration: none; 
            }
      
            hr {
              border: 0;
              border-bottom: 1px solid #f6f6f6;
              margin: 20px 0; 
            }
      
            /* -------------------------------------
                RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
            @media only screen and (max-width: 620px) {
              table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important; 
              }
              table[class=body] p,
              table[class=body] ul,
              table[class=body] ol,
              table[class=body] td,
              table[class=body] span,
              table[class=body] a {
                font-size: 16px !important; 
              }
              table[class=body] .wrapper,
              table[class=body] .article {
                padding: 10px !important; 
              }
              table[class=body] .content {
                padding: 0 !important; 
              }
              table[class=body] .container {
                padding: 0 !important;
                width: 100% !important; 
              }
              table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important; 
              }
              table[class=body] .btn table {
                width: 100% !important; 
              }
              table[class=body] .btn a {
                width: 100% !important; 
              }
              table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important; 
              }
            }
      
            /* -------------------------------------
                PRESERVE THESE STYLES IN THE HEAD
            ------------------------------------- */
            @media all {
              .ExternalClass {
                width: 100%; 
              }
              .ExternalClass,
              .ExternalClass p,
              .ExternalClass span,
              .ExternalClass font,
              .ExternalClass td,
              .ExternalClass div {
                line-height: 100%; 
              }
              .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important; 
              }
              #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
              }
              .btn-primary table td:hover {
                background-color: #34495e !important; 
              }
              .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important; 
              } 
            }
      
          </style>
        </head>
        <body class="">
        <span class="preheader">Você recebeu um e-mail do seu sistema.</span>
          <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
            <tr>
              <td>&nbsp;</td>
              <td class="container">
                <div class="content">
      
                  <!-- START CENTERED WHITE CONTAINER -->
                  <table role="presentation" class="main">
      
                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                      <td class="wrapper">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                            <h1>Olá, tudo bem ?
                            </h1>
                            <p>Foi solicitado através do sistema para redefinir sua senha.<br> Clique no link abaixo para redefinir sua senha.<br></p>';
                              $body .= $msg;
                              $body .= '<br><br>
                              <p><strong> Ah, se você não solicitou, favor excluir este e-mail.</strong></p><br><br>
                              <p>Obrigado.</p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
      
                  <!-- END MAIN CONTENT AREA -->
                  </table>
                  <!-- END CENTERED WHITE CONTAINER -->
      
                  <!-- START FOOTER -->
                  <div class="footer">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td class="content-block">
                          <span class="apple-link">&copy; "'.APP_TITLE.'"</span>.
                        </td>
                      </tr>
                      <tr>
                        <td class="content-block powered-by">
                        Desenvolvido por <a href="https://smartsolucoesinteligentes.com.br">Smart Soluções Inteligentes LTDA.</a>.
                        <br>
                        (62) 99363-5252
                        <br>
                        contato@smartsolucoesinteligentes.com.br</td>
                      </tr>
                    </table>
                  </div>
                  <!-- END FOOTER -->
      
                </div>
              </td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </body>
      </html>';

      $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
      try {
          //Server settings
          //  $mail->SMTPDebug = 2;                      // Enable verbose debug output
          $mail->isSMTP();                            // Set mailer to use SMTP
          $mail->Host = MAIL_HOST;                    // Specify main and backup SMTP servers
          $mail->SMTPAuth = MAIL_AUTH;                // Enable SMTP authentication
          $mail->Username = MAIL_USER;                // SMTP username
          $mail->Password = MAIL_PASS;                // SMTP password
          $mail->SMTPSecure = MAIL_SECURE;            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = MAIL_PORT;                    // TCP port to connect to
//            $mail->SMTPAutoTLS = true; // remover quando subir no servidor

          
          $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
          );

          $mail->IsHTML(true);                                    // Set email format to HTML
          $mail->CharSet = 'UTF-8';

          //Recipients
          $mail->setFrom($mail->Username, APP_TITLE);
          foreach ($email as $item) {
              $mail->addAddress($item);     // Add a recipient
          }
          $mail->addReplyTo($mail->Username, APP_TITLE);
          if($cc) $mail->addCC($cc);

          //Attachments
          if($anexo) $mail->addAttachment($anexo);    // Optional name use ',newName.ext'

          //Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $assunto;
          $mail->Body    = $body;
          $mail->AltBody = 'Este email contém html.';

          $mail->send();

         // return true;
          // echo 'Message has been sent';
      } catch (Exception $e) {
          return false;
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
      }

    }

}

