<?php

namespace Core;

class Pagination {

    //Ссылок навигации на страницу
    private $max = 10;
    //Ключ GET в который пишется номер страницы
    private $index = 'page';
    //Текущая страница
    private $current_page;

    //Количество записей
    private $total;
    //Записей на странице
    private $limit;

    public function __construct($total, $currentPage, $limit, $index) {
        //Устанавливаем общее количество записей
        $this->total = $total;
        //Устанавливаем количество записей на страницу
        $this->limit = $limit;
        //Устанавливаем ключ в url
        $this->index = $index;
        //Устанавливаем количество страниц
        $this->amount = $this->amount();
        //Устанавливаем номер текущей страницы
        $this->setCurrentPage($currentPage);
    }

    public function get() {
        //Для записи ссылок
        $links = null;
        //Получаем ограничения для цикла
        $limits = $this->limits();
        //var_dump($limits);
        $html = '<ul class="pagination-control">';
        //Генерируем ссылки
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li class="active"><a href="#">' . $page . '</a></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }

        //Ссылки на первую и последнюю страницу
        if (!is_null($links)) {
            //Текущая страница не первая
            if ($this->current_page > 1)
                //Создаем ссылку на первую
                $links = $this->generateHtml(1, '&lt;') . $links;
            //Если текущая страница не первая
            if ($this->current_page < $this->amount)
                //Создаем ссылку "на последнюю"
                $links .= $this->generateHtml($this->amount, '&gt;');
        }

        $html .= $links . '</ul>';
        return $html;
    }

    //Генерация HTML-кода ссылки
    private function generateHtml($page, $text = null) {
        //Ссылки на первую и последнюю страницы
        if (!$text) {
            $text = $page;
        }
        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/');
        $currentURI = preg_replace('~[&|?]page=[0-9]+~', '', $currentURI);
        $currentURI = preg_replace('~[&|?]sort=[A-Za-z0-9_-]+~', '', $currentURI);

        //Если страница главная (записи не отсортированы)
        if ($currentURI) {
            return '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
        } else {
            return '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
        }
    }

    //Для получения, откуда стартовать
    private function limits() {
        $left = $this->current_page - round($this->max/2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    //Для установки текущей страницы
    private function setCurrentPage($currentPage) {
        //Номер страницы
        $this->current_page = $currentPage;
        //Если страница больше нуля
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount)
                $this->current_page = $this->amount;
        } else {
            $this->current_page = 1;
        }
    }

    //Для получения общего числа страниц
    private function amount() {
        return ceil($this->total / $this->limit);
    }
}