<?php
global $oldPriceHtml, $newPriceHtml, $currencyDisplayHtml, $language, $lang;
?>

<style>
    body {
        margin-bottom: 73px;
    }
</style>
<script>
    check_bottom_margin();
</script>

<div id="plugin-quick-order" class="plugin-quick-order">
    <div class="plugin-quick-order-inner">
        <div class="plugin-quick-order-left">
            <div class="plugin-quick-order-title"><?php echo $lang['plugin_quick'] ?></div>
            <div class="plugin-quick-order-price">
                <s><?= $oldPriceHtml ?></s>
                <b><?= $newPriceHtml ?> <?= $currencyDisplayHtml ?></b>
            </div>
        </div>
        <form action="" method="post" id="plugin-quick-order-mobile_form" class="plugin-quick-order-mobile_form">
            <div class="plugin-quick-order-input_div">
                <div class="plugin-quick-order-select-country"><?= countrySelect() ?></div>
                <input class="plugin-quick-order-input_class" type="text" name="name"
                       placeholder="<?php echo $lang['name'] ?>">
                <input class="plugin-quick-order-input_class" type="phone" name="phone"
                       placeholder="<?php echo $lang['phone'] ?>">
                <input class=plugin-quick-order-submit_class" type="submit" value="<?php echo $lang['btn-send'] ?>">
            </div>
        </form>
    </div>
</div>
