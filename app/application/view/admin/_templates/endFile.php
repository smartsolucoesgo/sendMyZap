    </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
            Versão 1.0
            </div>

            <strong>Copyright &copy; <?php echo date('Y');?> <b style="color:#000000;"><?=APP_TITLE?></b>.</strong>
        </footer>
</div>

<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script>
<script src="/assets/dist/js/adminlte.js"></script>

<script>

$('[data-toggle="tooltip"]').tooltip()

var dark_mode = <?=$_SESSION['dark_mode'] ?>;
if(dark_mode == 1) {
    $('#dark').prop('checked', true);
    $('body').addClass('dark-mode')
} 
var text_pequeno = <?=$_SESSION['text_pequeno'] ?>;
if(text_pequeno == 1) {
    $('#text').prop('checked', true);
    $('body').addClass('text-sm')
    $('.main-header').addClass('text-sm')
    $('.brand-link').addClass('text-sm')
    $('.nav-sidebar').addClass('text-sm')
    $('.main-footer').addClass('text-sm')
}    

$("#dark").on('click', function(event){
    var user = <?=$_SESSION['id_user']?>;
    var param = {};
    param['dark_mode'] = dark_mode; 
    param['user'] = user; 

    setTimeout(function () {
        $.ajax({
            type: "POST",
            url: '<?= URL_PUBLIC ?>/ajax',
            dataType: 'text',
            data: {
                controller: 'Auth',
                action: 'darkMode',
                param: param
            },
            cache: false,
            success: function(result) {
                if(result.status == 'ativo') {
                    $('body').addClass('dark-mode')
                    location.reload();
                } else {
                    $('body').removeClass('dark-mode')
                    location.reload();
                }
            }
        }, 1000);
    })
});

$("#text").on('click', function(event){
    var user = <?=$_SESSION['id_user']?>;
    var param = {};
    param['text_pequeno'] = text_pequeno; 
    param['user'] = user; 

    setTimeout(function () {
        $.ajax({
            type: "POST",
            url: '<?= URL_PUBLIC ?>/ajax',
            dataType: 'text',
            data: {
                controller: 'Auth',
                action: 'text',
                param: param
            },
            cache: false,
            success: function(result) {
                if(result.status == 'ativo') {
                    location.reload();
                } else {
                    $('body').removeClass('text-sm')
                    $('.main-header').removeClass('text-sm')
                    $('.brand-link').removeClass('text-sm')
                    $('.nav-sidebar').removeClass('text-sm')
                    $('.main-footer').removeClass('text-sm')
                    location.reload();
                }
            }
        }, 1000);
    })
});
</script>

</body>

</html>
