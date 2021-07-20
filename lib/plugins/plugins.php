<?php

class PluginsInjector {

    public $template = 'plugins.tpl.php';
   
    public function __construct($params) {        
        $this->params = $params;        
    }
    
    public function __invoke($content, $cwd) {        
        return str_replace('</body>',  $this->code . '</body>', $content);
    }
    
    public function prepare() {        
        $this->code = $this->render();
    }

    private function render() {        
        ob_start();
        $params = $this->params;          
        $productPrice = $params['newPrice'];
        $productPriceOld = $params['oldPrice'];
        $productPricePromo = $params['promoPrice'];
        $productCurrency = $params['currency'];
        $client_city = $params['client_city'];

        $country_info = countrySelect();
        $country_info = str_replace("\n", "", $country_info);
        $country_info = str_replace("'", '"', $country_info);
        $country_info = preg_replace('/\s{2,}/', ' ', $country_info);
        
        require($this->template);
        $code = ob_get_clean();
        return $code;
    }
}
