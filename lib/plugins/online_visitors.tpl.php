<?php
global $shared_path;
?>
<style>
    .plugin-visitors-online-notify { right: auto; left: 8px; bottom: 8px;  background-color: #f7e7b6; display: block; color: #4f4f4f;}    
</style>
<?php global $language, $lang; ?>
<script>
    
   function showOnlineNotify() {       
    var count = mainNow != 0 ? mainNow : getRandomInt(45, 150);
    var bottom_margin = 11;

    mainNow = count;
    var res = '<?php echo $lang['plugin_visitors'] ?>'.replace("{count}", count);

    var html = '<div class="plugin-alert-box plugin-visitors-online-notify" style="bottom:' + bottom_margin + 'px !important;">' +
        '<div class="plugin-alert-close visitors-close">&times;</div>' +
        '<img src="shared/plugins/icons/notify-users.png">' +
        '<div class="plugin-notify-text">' + res + '</div>' +
        '</div>';
    $(html).appendTo($(document.body));
    check_bottom_margin();
    $('.visitors-close').on('click', function () {
        $('.plugin-visitors-online-notify').remove();
    });
    setInterval(function () {
        check_bottom_margin();        
    }, 2000);
}


    showOnlineNotify();

</script>