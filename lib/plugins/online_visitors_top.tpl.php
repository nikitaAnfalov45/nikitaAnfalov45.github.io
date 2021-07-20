<?php
global $shared_path;
?>
<style>
    body {padding-top:34px !important;}
    .visitors-panel-top {
        overflow: hidden; height: 36px; width:100%;
        box-sizing: border-box; z-index: 99999; text-align:center; background: #ededed; position: fixed;  top:0; left:0;
        font-size: 21px; display:inline-block;
        color: #4f4f4f;    
        overflow: hidden; height: 36px; width:100%;
        background: #e8e8e8;        
        border: 1px dashed #727272;
    }
    .visitors-panel-top span {color: #4f4f4f;}
    .visitors-panel-top.mobile {height: 34px; padding-top: 10px; font-size: 12px !important; box-sizing: border-box;}
    .visitors-panel-top span {font-family: "Open Sans", sans-serif !important; font-size:20px !important; line-height: 22px;}
    .visitors-panel-top.mobile .all-today{display:none;}
    .visitors-today {background-image: url(shared/plugins/icons/users-color-64.png);height: 28px;padding-left: 45px;background-repeat: no-repeat;background-position: 5px;margin-left: 10px;display: inline-block;padding-top: 8px;margin-top: 0;}
    .visitors-now {background-image: url(shared/plugins/icons/eye-color-64.png);height: 28px;padding-left: 45px;background-repeat: no-repeat;background-position: 5px;margin-left: 10px;display: inline-block;padding-top: 8px;margin-top: 0;border-left: 2px dashed #cccccc;}
    .buy-today {background-image: url(shared/plugins/icons/buy-color-64.png);height: 28px;padding-left: 45px;background-repeat: no-repeat;background-position: 5px;margin-left: 10px;display: inline-block;padding-top: 8px;margin-top: 0;border-left: 2px dashed #cccccc;}
    .visitors-panel-top.mobile .visitors-now{border-left:0;}
</style>
<?php global $language, $lang; ?>
<script>
    
    function onlineVisitorsTop(isMobile) {
        isMobile = isMobile ? isMobile : false;
        var visitorsToday = new Date().getHours() * 100 + Math.floor(Math.random() * 1000);
        var now = mainNow !== 0 ? mainNow : getRandomInt(45, 150);
        mainNow = now;
        var todayBuy = getRandomInt(50, 100) + new Date().getHours();
        if (visitorsToday <= todayBuy) {
            todayBuy = Math.floor(visitorsToday / 2) + 2;
        }
        var html = '<div class="visitors-panel-top'+(isMobile ? ' mobile' : '')+'">' +
            '<span class="visitors-today"><?php echo $lang['plugin_visitors_top'] ?>: <strong>' + visitorsToday + '</strong></span>' +
            '<span class="buy-today"><?php echo $lang['plugin_visitors_top_purchases'] ?>: <strong>' + todayBuy + '</strong></span>' +
            '<span class="visitors-now"><?php echo $lang['plugin_visitors_top_now'] ?>: <strong>' + now + '</strong></span>' +
            '</div>';
        $(html).appendTo($(document.body));
    }
    onlineVisitorsTop()
</script>