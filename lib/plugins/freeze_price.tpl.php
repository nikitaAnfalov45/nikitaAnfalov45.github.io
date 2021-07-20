<?php
global $shared_path;
?>
<style>
    .freezing-info-packages {font-size: 17px;color: #000000;padding-top: 12px;z-index: 2;position: relative;line-height: 1;}
    .freezing-info{font-family: Arial; z-index: 991000;color: black;width: 380px;height: 125px;position: fixed;
                   background: url("shared/plugins/icons/freeze_price.png") no-repeat;box-sizing: border-box;padding: 10px 30px;top:56px;right:0;
                   border: 2px dotted #345489;font-size: 100%;font: inherit;vertical-align: baseline; background-color: #fff; border-radius: 15px; margin-right:10px;}
    .freezing-info-price {font-size: 22px;color: #345489;z-index: 2;position: relative;margin-left: 3px; margin-top: 35px;}    
    
    .freezing-info-close {
        width:18px;
        height:18px;
        cursor: pointer;
        position:absolute; right:-5px; top:-5px;
        font-size: 22px;
        line-height: 0.6;
        text-align: center;
        border: 1px solid #345489;
        color: #345489;
        background-color: #fff;
        border-radius: 50%;
    }
    @media screen and (max-width: 480px){
    .freezing-info{
        display: none;
    }
}
</style>

    <script>
        $(document).ready(function () {
            $('.freezing-info-close').on('click', function () {
                $('.freezing-info').remove();
            });
        });
    </script>

<div class="freezing-info">
    <div class="freezing-info-close">&times;</div>
    <div class="freezing-info-price">1$ = 45 рублей</div>
    <div class="freezing-info-packages">Осталось 137 штук по старому курсу</div>
</div>