<?php

namespace Components;

class ProductGenerator
{
    //Массив данных для случайной генерации
    private $data;

    //Конструктор класса
    public function __construct() {
        $path = __DIR__ . '/products_data.php';
        $this->data = require_once ($path);
    }

    //Генерация случайного продукта
    public function generateProduct() {
        $product = array();
        $brandId = array_rand($this->data['brand']);
        $nameId = array_rand($this->data['name']);
        $typeId = array_rand($this->data['type']);
        $colorId = array_rand($this->data['color']);

        $product['articul'] = mt_rand(100, 8888888);
        $product['name'] = $this->data['name'][$nameId];
        $product['brand'] = $this->data['brand'][$brandId];
        $product['type'] = $this->data['type'][$typeId];
        $product['color'] = $this->data['color'][$colorId];
        $product['price'] = mt_rand(10000, 100000)/10;
        $product['discount'] = mt_rand(0, 10);
        $product['upload'] = $this->generateRandomDate();

        return $product;
    }

    //Сгенерировать случайную дату с разбегом до 1 года от текущей
    public function generateRandomDate() {
        return strftime('%Y-%m-%d', time()-(mt_rand(86400, 31536000)));
    }
}