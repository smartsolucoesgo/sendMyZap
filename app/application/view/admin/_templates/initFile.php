<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_TITLE . $title?></title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

    <?php
    foreach ($css as $file) {
        if(file_exists($file)) {
            echo '<link href="/' . $file . '" rel="stylesheet">';
        }
    }
    ?>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <?php
    foreach ($script as $file) {
        if(file_exists($file)) {
            echo '<script src="/' . $file . '"></script>';
        }
    }
    ?>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php if(@$menuList == true) {
      require APP . 'view/admin/_templates/menuList.php';
    } ?>

    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
          