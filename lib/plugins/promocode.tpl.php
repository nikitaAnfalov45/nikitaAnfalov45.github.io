<?php
global $shared_path, $language, $lang;
?>
<script src="shared/plugins/md5.js"></script>
<script>
    $(document).ready(function () {        
        $('x-newprice').html(productPricePromo);
        $("#promocode-check").on('click', function () {
            var promo = $('#promocode');
            var promocode = promo.val();
            var promo_control = promo.data('promo');           
            
            if (md5(promocode) === promo_control) {
                $('x-newprice').html(productPrice);
                $('.promocode-form').hide();
                $('.promocode-success').show();
            } else {
                $('.promocode-form').hide();
                $('.promocode-error').show();
                promo.val('');
                setTimeout(function() { $(".promocode-error").hide("fast", function() { $(".promocode-form").show(); }); }, 3000);
            }
        });
    });
</script>

<div id="promocode-block">
    <div class="promocode-inner">
        <div class="promocode-form">
            <div class="title"><?php echo $lang['plugin_promo'] ?>:</div>
            <input type="text" name="promocode" id="promocode" placeholder="<?php echo $lang['plugin_promo_placeholder'] ?>" data-promo="<?= $promocode ?>" >
            <button id="promocode-check"><?php echo $lang['plugin_promo_set'] ?></button>
        </div>
        <div class="clear"></div>
        <div class="promocode-success">
            <?php echo $lang['plugin_promo_thanks'] ?>
        </div>
        <div class="promocode-error">
            <?php echo $lang['plugin_promo_error'] ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
