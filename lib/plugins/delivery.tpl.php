<?php
global $shared_path;
?>
<style>
    .plugin-delivery-notify { right: auto; left: 8px; bottom: 6px; background-color: #4f4f4f; display: block;}    
</style>
<?php global $language, $lang; ?>
<script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
        window.onload = function () {
            client_city = ymaps.geolocation.city;        
        };
        
    function showDeliveryNotify() {        
        this.client_city = client_city;
        this.lang = '<?php echo $language; ?>';
        this.generateDeliveryHTML = function (city, lang) {
            var delivery = '<?php echo $lang['plugin_delivery'] ?>';
            if(city && lang === 'ru'){
                delivery = '<?php echo $lang['plugin_delivery_city'] ?>' + city;
            }
            return (
                '<div class="plugin-alert-box plugin-delivery-notify">' +
                '<div class="plugin-alert-close delivery-close">&times;</div>' +
                '<img src="shared/plugins/icons/notify-delivery-white.png">' +
                '<div class="plugin-notify-text">' + delivery + '</div>' +
                '</div>'
            );
        };
        this.bindEvents = function () {            
            $('.delivery-close').on('click', function () {
                $('.plugin-delivery-notify').remove();
            });
            $(document).on('wheel', function () {
                if ($(document).scrollTop() + $(window).height() == $(document).height()) {
                    if ($('.plugin-delivery-notify').length) {
                        $('.plugin-delivery-notify').remove();
                    }
                }
            });
        };
        this.getShowAction = function () {            
            var self = this;
            return function () {
                var html = self.generateDeliveryHTML(self.client_city, self.lang);
                $(html).appendTo($(document.body));
                check_bottom_margin();
                self.bindEvents();
            };
        };

        setTimeout(this.getShowAction(), 20000);
    }

    showDeliveryNotify();
</script>