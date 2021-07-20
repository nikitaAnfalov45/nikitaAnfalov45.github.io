<?php

class BeforeRenderCallback {

    private $callbacks;
    private $cwd;

    public function __construct($callbacks, $cwd=null) {
        $this->callbacks = $callbacks;
        $this->cwd = $cwd;
    }

    public function addCallback($callback) {
        $this->callbacks[] = $callback;
    }

    public function __invoke($content, $phase) {

        if ($this->cwd) {
            chdir($this->cwd);
        }

        $content = trim($content);
        foreach ($this->callbacks as $callback) {
            $content = $callback($content, $this->cwd);
        }
        return $content;
    }

    public function prepare() {
        foreach ($this->callbacks as $callback) {
            $callback->prepare();
        }
    }
}


class JsInjector {

    public $redirectUrl;
    public $render_context;
    private $code;

    public $utm = [
        "utm_source" => '',
        "utm_medium" => '',
        "utm_campaign" => '',
        "utm_content" => '',
        "utm_term" => '',

        "sub1" => '',
        "sub2" => '',
        "sub3" => '',
        "sub4" => '',
        "sub5" => '',

        'fb_pixel' => '',
        'fb_verify' => '',
        'ya_pixel' => '',
        'tiktok_pixel' => '',
        'mail_pixel' => '',
        'google_pixel' => '',
        'google_adw_pixel' => '',
        'vk_pixel' => '',
        'yandex_metrika' => '',
        'topmail_pixel' => '',

        'formFields' => '',
    ];

    public function __construct($params, $render_context) {
        $this->render_context = $render_context;

        foreach($this->utm as $key => $val) {
            $this->utm[$key] = clear_value(array_get($params, $key));
        }

        if($render_context['fb_verify']) {
            $this->utm['fb_verify'] = clear_value($render_context['fb_verify']);
        }
    }

    public function __invoke($content, $cwd) {
        $content = preg_replace('#<(?!header)head([^>])*>#',  '<head$1>' . "\n" .$this->code, $content, 1);
        return $content;
    }

    public function prepare() {
        $this->code = $this->render();
    }

    private function render() {
        ob_start();

        $dir = $this->render_context['dir'];
        $pixels = $this->render_context['pixels'];

        incl('js.app.php', array(
            'redirectUrl' => $this->redirectUrl,
            'utm' => $this->utm,
            'offer' => $this->render_context['offer'],
            'offers' => $this->render_context['offers'],
            'push_link' => $this->render_context['push_link'],
            'language' => $this->render_context['language'],
        ));

        if (isset($pixels)) {
            foreach($pixels as $pixel_name) {
                if ($this->utm[$pixel_name]) {
                    $pixel_id = $this->utm[$pixel_name];
                    require_once ($dir.'/pieces/trackers/'.$pixel_name.'.php');
                }

            }
        }
        incl($dir.'/trackers.php');
        $code = ob_get_clean();
        return $code;
    }
}

function incl($filename, $context=array()) {
    extract($context);
    require($filename);
}

function countrySelect() {

    global $offers, $offer;

    usort($offers, function($a, $b) {
        return strcmp($a['country']['name'], $b['country']['name']);
    });

    ob_start();
    ?>
    <input type="hidden" name="country" value="<?php echo $offer['country']['code']; ?>">
    <select name="offer" class="form-control country_chang" <?= count($offers) === 1 ?  'style="display: none;"' : ''?>>
        <?php foreach($offers as $offerData): ?>
            <option
                    data-country-code="<?php echo $offerData['country']['code'] ?>"
                <?php if ($offerData['id'] == $offer['id']): ?>
                    selected="selected"
                <?php endif ?>
                    value="<?php echo $offerData['id'] ?>"
            >
                <?php echo $offerData['country']['name'] ?>
            </option>
        <?php endforeach ?>
    </select>
    <?php
    return ob_get_clean();
}

function countryDefault() {

    global $offer;
    ob_start();
    ?>

    <select name="offer" class="form-control country_chang" style="display: none;">
        <option
                data-country-code="<?php echo $offer['country']['code']; ?>"
                selected="selected"
                value="<?php echo $offer['id'] ?>"
        >
            <?php echo $offer['country']['name'] ?>
        </option>
    </select>

    <?php
    return ob_get_clean();
}

function showForm($width, $height, $args) {

    /**
     * Функция создает HTML-разметку iframe с формой заказа
     *
     * @param $width string|integer ширина iframe в px или %
     * @param $height string|integer высота iframe в px или %
     * @param $args array параметры формы заказа
     * @return string HTML-разметка
     *
     * В массив $args можно передавать следующие параметры:
     *  language - язык на котором будет отбражаться форма: двузбуквенный код языка ISO 639-1
     *  country - страна по умолчанию: двухбуквенный код страны ISO 3166-1 Alpha-2
     *  select - оставить или скрыть выбор страны: 'countrySelect' или 'CountryDefault'
     *  is_price - чтобы скрыть цену передать значение 'no'
     *  color - доступные цвета: light, orange, blue, green, gray, dark
     *
     * Примеры вызова функции:
     *
     * showForm('80%', '600', ['color' => 'blue', 'country' => 'kz', 'is_price' => 'no']);
     * showForm(600, '600', ['color' => 'green', 'country' => 'kz', 'select' => 'countrySelect']);
     */

    ob_start();

    parse_str($_SERVER['QUERY_STRING'], $query_string);
    $query_params = array_merge($query_string, $args);

    $get_query = htmlentities(http_build_query($query_params, '&'));

    $src = "http://{$_SERVER['HTTP_HOST']}/form/?$get_query";

    ?> <iframe src='<?= $src ?>' width="<?= $width ?>" height="<?= $height ?>"></iframe> <?php

    return ob_get_clean();
}

function prepaid_info_html() {
}

function footer($id=2) {
    ob_start();
    incl(LANDING_DIR . "pieces/footer.{$id}.php");
    return ob_get_clean();
}

function normalizePrice($price) {
    if (null !== $price) {
        if (intval($price) == $price) {
            $price = intval($price);
        }
    }
    return $price;
}

function clear_value($input_text){
    $input_text = strip_tags($input_text);
    $input_text = htmlspecialchars($input_text);
    return $input_text;
}

function array_get($array, $key, $default=null) {
    if (is_array($array) && array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $default;
    }
}

function get_country($ip_address, $offers, $offer) {
    // Подключаем SxGeo.php класс
    include(__DIR__.'/geo/SxGeo.php');
    $SxGeo = new SxGeo(__DIR__.'/geo/SxGeo.dat');

    $countryDetect = $SxGeo->get($ip_address);

    return $countryDetect;
}

function get_offer_by_ip($ip_address, $offers, $offer){

    $country_code = get_country($ip_address, $offers, $offer);
    $offerDetected = $offer;
    foreach ($offers as $offerData){
        if ($offerData['country']['code'] == $country_code) {
            $offerDetected = $offerData;
        }
    }
    return $offerDetected;
}

function is_debug($set_display_error=False, $unset_cookie=False)
{
    // Проверяем включен ли debug mod
    global $_debug, $apiKey, $landKey, $dbg_mod;

    $dbg_mod = False;

    if ($_debug) {
        $dbg_mod = True;
    }

    if (isset($_GET['dbg']) && 1 == $_GET['dbg'] && isset($_GET['key']) && $apiKey == $_GET['key']) {
        $dbg_mod = True;

        // устанавливаем куку
        setcookie("dbg_hash", md5($landKey.$apiKey));
    } elseif ($unset_cookie && !$_debug) {
        setcookie("dbg_hash");
    }

    if (isset($_COOKIE['dbg_hash'])) {
        if ($_COOKIE['dbg_hash'] == md5($landKey.$apiKey)) {
            $dbg_mod = True;
        }
    }

    if ($dbg_mod and $set_display_error) {
        error_reporting(E_ALL);
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', '1');
    }

    return $dbg_mod;
}

function display_debug_info($title, $data) {
    // выводит информацию об ошибках
    global $dbg_mod;
    if ($dbg_mod) {
        echo '<h3>'.$title.'</h3>';
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

function pluginInjectorFactory($plugin, $pluginParams) {
    require_once("plugins/$plugin.php");
    $classname = str_replace('_', ' ', $plugin);
    $classname = ucwords($classname) . 'Injector';
    $classname = str_replace(' ', '', $classname);
    return new $classname($pluginParams);
}

function injectPlugins($renderCallback, $plugins, $pluginPrices) {
    if ($plugins) {
        $pluginsInjector = pluginInjectorFactory('plugins', $pluginPrices);
        $renderCallback->addCallback($pluginsInjector);
        foreach ($plugins as $plugin => $pluginParams) {
            $pluginsInjector = pluginInjectorFactory($plugin, $pluginParams);
            $renderCallback->addCallback($pluginsInjector);
        }
    }
}

function get_promo_price($price, $price_old){
    $price_promo = 0;
    if($price_old > 0 && $price_old > $price){
        $price_promo = intval($price + (($price_old - $price) / 2));
    }
    if($price_promo == 0){
        $price_promo = intval($price + $price * 0.02);
    }
    return $price_promo;
}

function checkPluginsConflict($plugins)
{
    $groups = [
        ['corona_delivery_top', 'corona_delivery_eng', 'online_visitors_top'],
        ['quick_order', 'promocode'],
    ];
    $conflicts =  array_map(function($g) use ($plugins) {
        return count(array_intersect_key(array_flip($g), $plugins)) > 1;
    }, $groups);

    return in_array(true, $conflicts);
}

function isPluginsExist($plugins)
{
    $exists = array_map(function($p) {
        return file_exists("lib/plugins/{$p}.php");
    }, array_keys($plugins));

    return !in_array(false, $exists);
}
