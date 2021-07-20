<?php

// Подключаем SxGeo.php класс
include("SxGeo.php");
$SxGeo = new SxGeo('SxGeo.dat');

$ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']);

var_export($SxGeo->get($ip));