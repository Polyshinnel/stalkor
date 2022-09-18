## Миграции

##### Папка с миграциями:

/src/Migration

##### Создание миграции:

php vendor/bin/phinx create НазваниеМиграции -c config-phinx.php

##### Миграция:

php vendor/bin/phinx migrate -c config-phinx.php

##### Ссылка на статью:

https://siipo.la/blog/how-to-use-eloquent-orm-migrations-outside-laravel


## Консольные комманды

##### Запуск парсеров:

php bin/console.php Название комманды

###### Запуск парсера категорий
! При первом запуске, парсер категорий требуется запустить три раза

php bin/console.php parse:Category

###### Запуск парсера товаров

php bin/console.php parse:Products


## Получение продуктов по API

Адрес запроса:

/getProducts

###### 1. Передаем заголовок:

    $header = [
        'Authorization: user:pass',
        'Content-Type:application/json'
    ];
    
###### 2. Передаем параметры:

    а). Получение всех продуктов: 
    
    $data = array(
        'filter' => [
            'params' => 'all_products'
        ]
    );
    
    б). Получение всех категорий:
    
    $data = array(
        'filter' => [
            'params' => 'all_categories'
        ]
    );
    
    в).Получение категорий с продуктами
    $data = array(
         'filter' => [
            'params' => 'products_categories'
         ]
     );
    
    г). Получение всех типов столбцов:
    
    $data = array(
        'filter' => [
            'params' => 'all_types'
        ]
    );
    
    д). Получение товаров конкретной категории по ее id:
    
    $data = array(
        'filter' => [
            'category_id' => '90'
        ]
    );


###### 3. Получаем json:

```php
    $urlrest = 'http://stalkor.web/getProducts';
    $header = [
        'Authorization: user:pass',
        'Content-Type:application/json'
    ];
    
    $data = array(
        'filter' => [
            'category_id'  => '90',
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
```

Результат работы:

```json
[
  {
    "id": 2747,
    "name": "Канат стальной 3.5 ГОСТ 3066-80",
    "category_id": 90,
    "site_id": "TXT",
    "param_one": "3,5",
    "param_two": null,
    "param_three": null,
    "price_one": "5,50",
    "price_two": "5,50",
    "date_update": "2022-09-07 00:00:00"
  },
  {
    "id": 2748,
    "name": "Канат стальной 3.7 ГОСТ 3069-80",
    "category_id": 90,
    "site_id": "TXV",
    "param_one": "3,7",
    "param_two": null,
    "param_three": null,
    "price_one": "4,40",
    "price_two": "4,40",
    "date_update": "2022-09-07 00:00:00"
  }
]
```


