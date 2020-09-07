<?php

$start = microtime(1);

include_once 'lib/curl.php';
include_once 'lib/simple_html_dom.php';

$pizza = curl::app('https://ntschool.ru')
    ->set(CURLOPT_HEADER, 1)
    ->set(CURLOPT_REFERER, 'https://www.google.ru')
    ->set(CURLOPT_TIMEOUT, 15)
    ->set(CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:80.0) Gecko/20100101 Firefox/80.0");


$html = $pizza->request('kursyi');
$dom = str_get_html($html);
$content = $dom->find('.courses-list--item-body');

$i = 0;
$arr_a = array();
foreach ($content as $el) {
    $a = $el->find('a', 0);
    $href = $a->href;
    $text_a = $a->plaintext;

    $price = $el->find('div', 1);
    $text_price = str_split($price->plaintext);

    $arr_a[$i] = "<a href='$href'>$text_a</a>";
    $i++;
}

$i = 0;
$arr_price = array();
$content = $dom->find('.newPrice');
foreach ($content as $el) {
    $price = $el->plaintext;
    $arr_price[$i] = $price;
    $i++;
}

for ($i = 0; $i < count($arr_a); $i++) {
    echo '<p>' . $arr_a[$i] . ' ' . $arr_price[$i] .'</p>';
}

echo microtime(1) - $start;
