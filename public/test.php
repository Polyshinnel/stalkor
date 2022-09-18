<?php /** @noinspection ALL */

//Тестовый файл для проверки работы парсера

//URL Парсера
$urlrest = 'http://stalkor.web/getProducts';

//Ключ авторизации
$header = [
    'Authorization: admin_user:test123',
    'Content-Type:application/json'
];

$data = array(
    'filter' => [
        'params'  => 'all_types',
    ]
);

$ch = curl_init($urlrest);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);

print_r($res);

