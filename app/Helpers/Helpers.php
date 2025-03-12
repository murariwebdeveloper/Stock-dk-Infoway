<?php

if (! function_exists('asset')) {
    function asset($path, $secure = null){
        return app('url')->asset("public/".$path, $secure);
    }
}

if (! function_exists('appName')) {
    function appName(){
        return "E-com";
    }
}

if (! function_exists('baseUrl')) {
    function baseUrl(){
        return url('/');
    }
}

if (! function_exists('webAssets')) {
    function webAssets(){
        $imagePath = asset('/')."web/assets/";
        return $imagePath;
    }
}

if (! function_exists('isLocal')) {
    function isLocal(){
        if (isset($_SERVER['SERVER_NAME']) && isset($_SERVER['REMOTE_ADDR'])) {
            $serverName = $_SERVER['SERVER_NAME'];
            $serverIp = $_SERVER['REMOTE_ADDR'];
            $localIp = array('localhost', '127.0.0.1', '::1');
            return in_array($serverName, $localIp) || in_array($serverIp, $localIp);
        }
        return false;
    }
}

if (! function_exists('decode')) {
    function decode($string){
        return base64_encode($string);
    }
}

if (! function_exists('encode')) {
    function encode($code){
        return base64_decode($code);
    }
}

if (! function_exists('statusHtml')) {
    function statusHtml($status){
        $html = $status;
        if($status == ACTIVE_CODE){
            $html = '<span class="main-badge success-badge">'.ACTIVE.'</span>';
        }

        if($status == INACTIVE_CODE){
            $html = '<span class="main-badge danger-badge">'.INACTIVE.'</span>';
        }
        return $html;
    }
}

if (! function_exists('availabilityHtml')) {
    function availabilityHtml($availability){
        $html = $availability;
        if($availability == AVAILABLE_CODE){
            $html = '<span class="main-badge success-badge">'.AVAILABLE.'</span>';
        }

        if($availability == UNAVAILABLE_CODE){
            $html = '<span class="main-badge danger-badge">'.UNAVAILABLE.'</span>';
        }

        if($availability == SOLD_OUT_CODE){
            $html = '<span class="main-badge bg-secondary text-white">'.SOLD_OUT.'</span>';
        }

        return $html;
    }
}

if (! function_exists('setCurrency')) {
    function setCurrency($amount){
        $currency = \App\Models\Setting::getValue('currency');
        $amount = $currency." ".$amount;
        return $amount;
    }
}


?>
