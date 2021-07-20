    window.addEventListener("load", function (event) {
        var neutralCultureName = "ru";
        window.cookieconsent.initialise({
            "palette": {
                "popup": { "background": "#3c404d", "text": "#d6d6d6" },
                "button": { "background": "#222", "text": "#fff" }
            },
            "theme": "classic",
            "content": {
                "message": "Acest site foloseşte cookie-uri pentru a vă oferi un conținut personalizat mai bun. Dacă nu sunteți de acord, modificați setările cookie-urilor din browserul dvs. Citiţi mai mul aici:", 
                "dismiss": "Sunt de acord", 
                "link": "Politica noastră de confidențialitate", 
                "href": "common/termeni2_ro.html" 
            },
            "cookie": {
                "expiryDays": 30
            },
            "elements": { 
                "messagelink": '<span id="cookieconsent:desc" class="cc-message">{{message}} <a aria-label="{{link}}"  class="cc-link" href="{{href}}" target="_blank">{{link}}</a></span>'
            }
        });
    });   
  
  
  $(document).ready(function() {
  


	var showLoading = function(){
		$('body').append('<div class="loaderForm"></div>');
	};
	var hideLoading = function(){
		$('div.loaderForm').animate({opacity: 0}, function(){
			setTimeout(function() { $('div.loaderForm').remove(); }, 1000);
		});
	};


	var setCookieWS = function(name, value, expires, path, domain, secure){
		document.cookie = name + "=" + escape(value) +
			((expires) ? "; expires=" + expires : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");

	};

	var getCookieWS = function(name){
		var cookie = " " + document.cookie;
		var search = " " + name + "=";
		var setStr = null;
		var offset = 0;
		var end = 0;
		if (cookie.length > 0) {
			offset = cookie.indexOf(search);
			if (offset != -1) {
				offset += search.length;
				end = cookie.indexOf(";", offset)
				if (end == -1) {
					end = cookie.length;
				}
				setStr = unescape(cookie.substring(offset, end));
			}
		}
		return(setStr);
	};      
  
	$(".order_form").submit(function() {
        var form = $(this);
		var name = form.find('[name="NAME"]').val();
		var phone = form.find('[name="PHONE_WORK"]').val();
		
		if(name == ''){alert('Cum va numiti!');return false;}
		if(phone == ''){alert('Introduceti numarul de telefon!');return false;}		
		
		if (name == '' || phone == '') return false;
		
		
		var prod = form.find('[name="TITLE"]').val();
		var products = getCookieWS('products');
		if(products == '' || products == null || typeof products == 'undefined') {
			products = '';
		} else {
			products = decodeURIComponent(products); 				
		}
		var current_product = prod;
		var new_products = (products == '') ? current_product : products+'??'+current_product;
		$('[name="TITLE"]').val(new_products);
		var date = new Date(new Date().getTime()+(60 * 60 * 24 * 365)).toUTCString();
		setCookieWS('products',encodeURIComponent (new_products),date,'../../default.htm','.'+location.host);
		setCookieWS('name',encodeURIComponent(name),date,'../../default.htm','.'+location.host,'');
		setCookieWS('phone',phone,date,'../../default.htm','.'+location.host,'');	
		$('[name="TITLE"]').val(prod);		
		
		showLoading();	
		//utm
		if (typeof result['utm_campaign'] != 'undefined' && result['utm_campaign'] != '') {
			form.append('<input name="utm_campaign"  value="'+result['utm_campaign']+'" type="hidden">');
		}
		if (typeof result['utm_medium'] != 'undefined' && result['utm_medium'] != '') {
			form.append('<input name="utm_medium"  value="'+result['utm_medium']+'" type="hidden">');
		}
		if (typeof result['utm_source'] != 'undefined' && result['utm_source'] != '') {
			form.append('<input name="utm_source"  value="'+result['utm_source']+'" type="hidden">');
		}
		if (typeof result['utm_content'] != 'undefined' && result['utm_content'] != '') {
			form.append('<input name="utm_content"  value="'+result['utm_content']+'" type="hidden">');
		}		
		if (typeof result['utm_term'] != 'undefined' && result['utm_term'] != '') {
			form.append('<input name="utm_term"  value="'+result['utm_term']+'" type="hidden">');
		}			
		//utm
		
		//pid
		form.append('<input name="pidd"  value="a3a9535a5d865c37b17b29c7a3b83413" type="hidden">');
		
		
		showLoading();		
		$.ajax({
			type: "POST",
			url: "common/rest_api.php@geo=ro&pid="+data_id,
			data: form.serialize(),
			dataType: 'json'
		}).done(function(data) {
			if (data.status == 'success') {
				if (typeof data.orderid !== 'undefined') {
					var date = new Date(new Date().getTime()+(60 * 60 * 24 * 365)).toUTCString();
					setCookieWS('order_id',data.orderid,date,'../../default.htm','.'+location.host,'');
				}
				setTimeout(function() { location.href='common/done.html@fbid='+result['fbid']; }, 200);
			}
		}); 
			
		return false;
	});
});