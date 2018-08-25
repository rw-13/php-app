<?php

namespace Modules\Product\Model;

use Core;

class Product
{
    private static $sortingFields = [
        'name',
        'brand',
        'price',
        'discount',
        'upload',
    ];

    const SORTING_DESC = 'DESC';
    const SORTING_ASC = 'ASC';

    //Добавить запись в БД
    public static function addProduct($params) {
        $db = Core\Db::getConnection();

        try {
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $db->beginTransaction();

            for ($i = 0; $i < count($params); $i++) {
                $articul = $params[$i]['articul'];
                $name = $params[$i]['name'];
                $brand = $params[$i]['brand'];
                $type = $params[$i]['type'];
                $color = $params[$i]['color'];
                $price = $params[$i]['price'];
                $discount = $params[$i]['discount'];
                $upload = $params[$i]['upload'];

                $sql = 'INSERT INTO `product` (`articul`, `name`, `brand`, `type`, `color`, `price`, `discount`, `upload`)
                  VALUES (:articul, :name, :brand, :type, :color, :price, :discount, :upload)';

                $result = $db->prepare($sql);
                $result->execute([
                    'articul'=>$articul,
                    'name'=>$name,
                    'brand'=>$brand,
                    'type'=>$type,
                    'color'=>$color,
                    'price'=>$price,
                    'discount'=>$discount,
                    'upload'=>$upload,
                ]);
            }

            $db->commit();

        } catch (\PDOException $e) {
            die ("ERROR\t\n\n\n" . $e->getMessage());
        }
    }

    public static function getAllProducts($mes_page, $page)
    {
        $db = Core\Db::getConnection();
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        try {
            $offset = ($page-1)*$mes_page;
            $sql = 'SELECT * FROM `product` ORDER BY `upload` DESC LIMIT :mespage OFFSET :offset';
            $result = $db->prepare($sql);
            $result->bindValue(':mespage', $mes_page, \PDO::PARAM_INT);
            $result->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $result->execute();

        } catch (\PDOException $e)  {
            echo "ERROR".$e->getMessage();
        }

        return $result->fetchAll();
    }

    //Получить количество всех записей из БД
    public static function getCount() {
        $db = Core\Db::getConnection();
        $sql = "SELECT COUNT(*) FROM product";
        $result = $db->query($sql)->fetch();
        
        return (int)$result[0];
    }

    public static function filter_old($filterParams, $sortingParams, $mes_page=10, $page)
    {
        //if (!in_array($filterParams['fieldname'], self::$sortingFields)) { throw new \Exception('Not allowed param'); }
        $offset = ($page-1)*$mes_page;
        $db = Core\Db::getConnection();
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {

            $sql = 'SELECT * FROM `product` ';

            $sql .= 'WHERE `name` LIKE :name AND (`type` LIKE :type) ';
            $sql .= 'AND (`brand` LIKE :brand) AND (`price` BETWEEN :pricefrom AND :priceto) ';
            $sql .= 'AND (`upload` BETWEEN :datefrom AND :dateto) ';
            //$sql .= (isset($sortingParams)) ? ('ORDER BY `'.$sortingParams['fieldname'].'` '.$sortingParams['sorting']) : '';
            $sql .= ' LIMIT '.$mes_page.' OFFSET '.$offset;

            $result = $db->prepare($sql);
            $result->execute([
                'name' => $filterParams['name'],
                'type' => $filterParams['type'],
                'brand' => $filterParams['brand'],
                'pricefrom' => $filterParams['price_from'],
                'priceto' => $filterParams['price_to'],
                'datefrom' => $filterParams['date_from'],
                'dateto' => $filterParams['date_to']
            ]);
        } catch (\PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function filterWithSorting($filterParams, $sortingParams, $mes_page=10, $page)
    {
        $offset = ($page-1)*$mes_page;
        $db = Core\Db::getConnection();
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {

            $sql = 'SELECT * FROM `product` ';
            $sql .= 'WHERE `name` LIKE :name AND (`type` LIKE :type) ';
            $sql .= 'AND (`brand` LIKE :brand) AND (`price` BETWEEN :pricefrom AND :priceto) ';
            $sql .= 'AND (`upload` BETWEEN :datefrom AND :dateto) ';
            $sql .= 'ORDER BY `'.$sortingParams['fieldname'].'` '.$sortingParams['sorting'];
            $sql .= ' LIMIT '.$mes_page.' OFFSET '.$offset;

            $result = $db->prepare($sql);
            $result->execute([
                'name' => $filterParams['name'],
                'type' => $filterParams['type'],
                'brand' => $filterParams['brand'],
                'pricefrom' => $filterParams['price_from'],
                'priceto' => $filterParams['price_to'],
                'datefrom' => $filterParams['date_from'],
                'dateto' => $filterParams['date_to']
            ]);
        } catch (\PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Получить сортированный список продуктов
    public static function getSortingList($fieldname, $sorting, $mes_page, $page, $filterParams = []) {

        // if (!in_array($fieldname, $this->sortingFields)) { throw new \Exception('Not allowed param')}
        $offset = ($page-1)*$mes_page;
        $db = Core\Db::getConnection();
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $sql = 'SELECT * FROM `product` ';
            $sql .= 'ORDER BY `'.$fieldname.'` ';
            $sql .= $sorting;
            $sql .= ' LIMIT :mespage OFFSET :offset';

            $result = $db->prepare($sql);
            $result->bindParam(':mespage', $mes_page, \PDO::PARAM_INT);
            $result->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $result->execute();
        } catch (\PDOException $e)  {
            echo "ERROR" . $e->getMessage();
        }

        return $result->fetchAll();
    }

    //Возвращает количество записей в фильтре
    public static function filter($params, $isCount = false, $rows_per_page = 10, $page = 1, $sortCond = false) {

        $offset = ($page-1)*$rows_per_page;

        // Добавляем цикл по параметрам фильтрации, строим запрос динамически
        $sql = 'SELECT ';
        if ($isCount) {
            $sql .= ' COUNT(*) ';
        } else {
            $sql .= ' * ';
        }
        $sql .= ' FROM `product` WHERE ';
        $paramValues = [];
        if ($params) {
            foreach ($params as $paramName => $paramData) {
                switch ($paramData['meta']['type']) {
                    case 'from':
                        // case for >=
                        $fieldName = str_replace('_from', '', $paramName);
                        $sql .= '`' . $fieldName . '` >= :' . $paramName;
                        break;
                    case 'to':
                        // case for <=
                        $fieldName = str_replace('_to', '', $paramName);
                        $sql .= '`' . $fieldName . '` <=:' . $paramName;
                        break;
                    case 'like':
                        $sql .= '`' . $paramName . '` LIKE :' . $paramName;
                        break;
                }
                $sql .= ' AND ';
                $paramValues[$paramName] = $paramData['value'];
            }
        } else {
            $sql .= ' 1 ';
        }
        $sql = rtrim($sql, ' AND ');
        if ($sortCond) {
            $sql .= ' ORDER BY ' . $sortCond;
        }
        $sql .= ' LIMIT ' . $rows_per_page . ' OFFSET ' . $offset;


        $db = Core\Db::getConnection();

        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $result = $db->prepare($sql);
            $result->execute($paramValues);
        } catch (\PDOException $e) {
            echo 'ERROR ' . $e->getMessage();
            die();
        }

        if ($isCount) {
            return $result->fetch()[0];
        } else {
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    //Установить фильтр на записи
    public static function setFilter($params, $page) {
        $db = Core\Db::getConnection();
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $offset = ($page-1)*10;
        try {
            $sql = "SELECT * FROM `product` WHERE `name` LIKE :name AND `type` LIKE :type " .
                "AND `brand` LIKE :brand AND (`price` BETWEEN :pricefrom AND :priceto) " .
                "AND (`upload` BETWEEN :datefrom AND :dateto) LIMIT 10 OFFSET $offset";

            var_dump($sql);
            $result = $db->prepare($sql);
            $result->execute([
                'name' => $params['name'],
                'type' => $params['type'],
                'brand' => $params['brand'],
                'pricefrom' => $params['price_from'],
                'priceto' => $params['price_to'],
                'datefrom' => $params['date_from'],
                'dateto' => $params['date_to'],
            ]);

        } catch (\PDOException $e) {
            echo "ERROR\n\t\t" . $e->getMessage();
        }

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Возвращает год добавления самого первого товара
    public static function getYearFirstProduct() {
        try {
            $db = Core\Db::getConnection();
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT MIN(upload) FROM product";
            $result = $db->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo "ERROR\n\t" . $e->getMessage();
        }

        return $result[0];
    }

    //Возвращает год добавления самого последнего товара
    public static function getYearLastProduct() {
        try {
            $db = Core\Db::getConnection();
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT MAX(upload) FROM product";
            $result = $db->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo "ERROR\n\t" . $e->getMessage();
        }

        return $result[0];
    }

    //Возвращает минимальную стоимость товара
    public static function getMinCostProduct() {
        try {
            $db = Core\Db::getConnection();
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT MIN(price) FROM product";
            $result = $db->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo "ERROR\n\t" . $e->getMessage();
        }

        return $result[0];
    }

    //Возвращает максимальную стоимость товара
    public static function getMaxCostProduct() {
        try {
            $db = Core\Db::getConnection();
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT MAX(price) FROM product";
            $result = $db->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo "ERROR\n\t" . $e->getMessage();
        }

        return $result[0];
    }

}