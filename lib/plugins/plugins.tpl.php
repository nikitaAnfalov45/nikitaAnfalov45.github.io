<?php global $language, $lang, $shared_path; ?>
<link rel="stylesheet" href="shared/plugins/plugins.css?v=3">
<script>
    var plugin_popup = '<?php echo $lang['plugin_popup'] ?>';
    var plugin_popup_head = '<?php echo $lang['plugin_popup_head'] ?>';
    var plugin_popup_recall_me = '<?php echo $lang['plugin_popup_recall_me'] ?>';
    var plugin_popup_operator = '<?php echo $lang['plugin_popup_operator'] ?>';
    var plugin_name = '<?php echo $lang['name'] ?>';
    var plugin_phone = '<?php echo $lang['phone'] ?>';
    var plugin_country = '<?php echo $country_info ?>';
</script>
<script src="shared/plugins/plugins.js?v=2"></script>
<script src="shared/plugins/popup.js?v=7" type="text/javascript"></script>
<script>
    var mainNow = 0;    
    var productPrice = <?= $productPrice ?>;
    var productPriceOld = <?= $productPriceOld ?>;
    var productPricePromo = <?= $productPricePromo ?>;
    var productCurrency = '<?= $productCurrency ?>';
    var client_city = '<?= $client_city ?>';
    
    function check_bottom_margin(){
        
        var margin_bottom = 0;
        
        if ($('.plugin-quick-order').length || $('#promocode-block').length) {            
            margin_bottom = 80;            
        }  
        
        if ($('.plugin-delivery-notify').length) {            
            $('.plugin-delivery-notify').css('bottom', margin_bottom);
            margin_bottom = 180;
        } 
        
        if ($('.plugin-visitors-online-notify').length) {            
            $('.plugin-visitors-online-notify').css('bottom', margin_bottom);
            margin_bottom = 180;
        } 
    }
</script>
