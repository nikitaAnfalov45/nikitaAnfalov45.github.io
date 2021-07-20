<?php
global $shared_path;
?>
<style>
    .plugin-made-order { right: 20px; left: auto; bottom: auto; background-color: #2f96b4;}
</style>
<script>
names = shuffleArray(names);

function showMadeOrder() {    
    this.productPrice = productPrice;
    this.currency = productCurrency;
    this.client_city = client_city;
    this.showItem = 0;
    
    this.generateHTML = function (city) {        
        var client_name = names[Math.floor(Math.random() * names.length)];
        var name = client_name.name;
        var gender = client_name.gender;
        
        var top = 50;
        if ($('.freezing-info').length) {
            top = 229;
        }
        
        var countProduct = getRandomInt(1, 2);
        var price = countProduct * this.productPrice;
        var priceInfo = price + ' ' + this.currency;            
        var str_count = countProduct + ' шт';
        
        var gender_action = 'сделал';
        if(gender === 'f'){
            gender_action = 'сделала'
        }

        if (city !== '') {
            city = ', г. ' + city;
        }

        return (
        '<div class="plugin-alert-box plugin-made-order" style="top:' + top + 'px;">' +                
        '<img src="shared/plugins/icons/notify-buy-white.png">' +
        '<div class="plugin-notify-text">' + name + city + ', ' + gender_action + ' заказ' + '</div>' +
        '</div>'
        );
    };

    this.newItem = function (html) {        
        $(html).appendTo($(document.body));
        $('.plugin-made-order').css('display', 'block')
            .animate({opacity: 1.0}, 'slow');
        self.setTimeoutEvent();
    };

    this.setTimeoutEvent = function () {        
        setTimeout(function () {
            $('.plugin-made-order').animate({
                opacity: 0.1
            }, 'slow', function () {
                $('.plugin-made-order').css('display', 'none').remove();
            });
        }, 6000);
    };

    this.nextAction = function () {        
        var self = this;
        return function () {
            var city = self.client_city;

            if (getRandomInt(0, 1)) {
                city = cityList[Math.floor(Math.random() * cityList.length)];
            }

            var html = self.generateHTML(city);
            self.newItem(html);

        }
    };
    setInterval(this.nextAction(), 30000);
}


showMadeOrder();
</script>