<?php
/**
 * Check if all prices exists an not zero size and regenerate if so.
 * User: T-ray
 * Date: 24.08.2015
 * Time: 18:57
 */

$download_dir = getcwd()."/download/";

$pricenavigator_file = $download_dir.'pricenavigator.yml';
$pricenavigator_url = 'http://economtochka.com.ua/index.php?route=export/yml';

$promua_file = $download_dir.'promua.yml';
$promua_url = 'http://economtochka.com.ua/index.php?route=export/promua';

$yandex_file = $download_dir.'yandex.yml';
$yandex_url = 'http://economtochka.com.ua/index.php?route=export/yandex';

$yandex_market_v2_file = $download_dir.'yandex_market_v2.yml';
$yandex_market_v2_url = 'http://economtochka.com.ua/index.php?route=export/yandex_market_v2';

if (!file_exists($pricenavigator_file) || (file_exists($pricenavigator_file) && filesize($pricenavigator_file) == 0)) {
    file_put_contents($pricenavigator_file, file_get_contents($pricenavigator_url));
}

if (!file_exists($promua_file) || (file_exists($promua_file) && filesize($promua_file) == 0)) {
    file_put_contents($promua_file, file_get_contents($promua_url));
}

if (!file_exists($yandex_file) || (file_exists($yandex_file) && filesize($yandex_file) == 0)) {
    file_put_contents($yandex_file, file_get_contents($yandex_url));
}

if (!file_exists($yandex_market_v2_file) || (file_exists($yandex_market_v2_file) && filesize($yandex_market_v2_file) == 0)) {
    file_put_contents($yandex_market_v2_file, file_get_contents($yandex_market_v2_url));
}
