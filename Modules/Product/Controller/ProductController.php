<?php

namespace Modules\Product\Controller;

use Core\Request;
use Core\Pagination;
use Components\ProductGenerator;
use Modules\Product\Form\SearchForm;
use Modules\Product\Model\Product;
use Core\ViewModel;


class ProductController
{
    public function actionMain($requestArg)
    {
        $searchForm = new SearchForm();
        $searchForm->setFilterParams($requestArg);

        $filterParams = $searchForm->getFilterParams();

        $page = (isset($requestArg['page']) && !empty($requestArg['page'])) ? (int)$requestArg['page'] : 1;
        $sortByField = isset($requestArg['sort']) ? $requestArg['sort']: false;
        $sortCond = false;

        if ($sortByField) {
            if (isset($_SESSION['sortBy']) && $_SESSION['sortBy']['field'] == $sortByField) {
                $sortType = ($_SESSION['sortBy']['type'] == 'ASC') ? 'DESC' : 'ASC';
            } else {
                $sortType = 'ASC';
            }
            $sortBy['type'] = $_SESSION['sortBy']['type'] = $sortType;
            $sortBy['field'] = $_SESSION['sortBy']['field'] = $sortByField;
            $sortCond = '`' . $sortByField . '` ' . $sortType;
        } else if (isset($_SESSION['sortBy']))  {
            $sortCond = '`' . $_SESSION['sortBy']['field'] . '` ' . $_SESSION['sortBy']['type'];
        }

        $countRows = Product::filter($filterParams, true);
        $products = Product::filter($filterParams, false, 10, $page, $sortCond);
        $pagination = new Pagination($countRows, $page, $mes_page=10, '&page=');

        /* Генерация ссылок и полей в таблице*/
        $sortBy['type'] =(isset($_SESSION['sortBy']['type']) && !empty($_SESSION['sortBy']['type'])) ? ($_SESSION['sortBy']['type']) : null;
        $sortBy['field'] = (isset($_SESSION['sortBy']['field']) && !empty($_SESSION['sortBy']['type'])) ? ($_SESSION['sortBy']['type']) : null;
        //Генерирует ссылки на упорядочивание товаров в заголовке таблицы
        $sortBy['refUri'] = function ($flagForm, $field) {
            $reference = '';
            switch ($flagForm)
            {
                //Есть данные с формы
                case true:
                    $uri = '&sort='.$field;

                    $address = $_SERVER['REQUEST_URI'];
                    $pattern = '/&sort[a-zA-Z]*=[a-zA-Z]*/';
                    $add = preg_replace($pattern, '', $address);

                    $reference = $add.$uri;
                    break;

                //Нет данных с формы
                case false:
                    $reference = '/product/main?sort='.$field;
                    break;
            }
            return $reference;
        };
        //Генерирует символ сортировки в заголовке таблицы
        $sortBy['signSort'] = function($sortBy, $field) {
            $sign = '';
            if (isset($sortBy) && $sortBy['field']==$field)
            {
                switch ($sortBy['type']) {
                    case 'ASC':
                        $sign = '<i class="fa fa-caret-up" aria-hidden="true"></i>';
                        break;
                    case 'DESC':
                        $sign = '<i class="fa fa-caret-down" aria-hidden="true"></i>';
                        break;
                }
            }
            return $sign;
        };

        return new ViewModel([
            'data' => $products,
            'filterParams' => $filterParams,
            'sortBy' => $sortBy,
            'pagination' => $pagination,
        ]);
    }

    //Заполнить таблицу данными
    public function actionFill() {
        $product = new ProductGenerator();
        $productArray = array();
        for ($i=0; $i<1000; $i++) {
            $productArray[] = $product->generateProduct();
        }
//        var_dump($productArray); die();
        Product::addProduct($productArray);

        $host = $_SERVER['HTTP_HOST'];
        $uri = '/product/main';
        header("Location: http://$host$uri");
    }


}