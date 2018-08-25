<?php //var_dump($this->viewData['filterParams']); ?>
<div id="header-top">
    <div id="left-block">
        <a href="/">Вернуться на главную</a>
        <a href="/product/fill">Сгенерировать +1000 записей</a>
        <br><br>
    </div>
    <div id="right-block">
        <form action="/product/main" id="filtration-form" name="filtration-form" method="get">
            <input type="text" id="name" name="name" placeholder="Наименование" value="<?=  (isset($this->viewData['filterParams']) && array_key_exists('name', $this->viewData['filterParams'])) ? $this->viewData['filterParams']['name']['value']: '' ?>">
            <input type="text" id="brand" name="brand" placeholder="Производитель" value="<?= (isset($this->viewData['filterParams']) && array_key_exists('brand', $this->viewData['filterParams']))? $this->viewData['filterParams']['brand']['value']: '' ?>">
            <input type="text" id="type" name="type" placeholder="Тип продукта" value="<?= (isset($this->viewData['filterParams']) && array_key_exists('type', $this->viewData['filterParams']))? $this->viewData['filterParams']['type']['value']: '' ?>">
            <div id="price-input">
                <input type="text" id="price_from" name="price_from" placeholder="Цена с, руб" value="<?= (isset($this->viewData['filterParams']) && array_key_exists('price_from', $this->viewData['filterParams']) )? $this->viewData['filterParams']['price_from']['value']: '' ?>">
                <input type="text" id="price_to" name="price_to" placeholder="Цена по, руб" value="<?= ( isset($this->viewData['filterParams']) && array_key_exists('price_to', $this->viewData['filterParams']) )? $this->viewData['filterParams']['price_to']['value']: '' ?>">
            </div>
            <div class="date-input">
                <label for="upload_from">Диапазон от</label>
                <input type="date" id="upload_from" name="upload_from" value="<?= ( isset($this->viewData['filterParams']) && array_key_exists('upload_from', $this->viewData['filterParams']) )? $this->viewData['filterParams']['upload_from']['value']: '' ?>">
            </div>
            <div class="date-input">
                <label for="upload_to">Диапазон до</label>
                <input type="date" id="upload_to" name="upload_to" value="<?= ( isset($this->viewData['filterParams']) && array_key_exists('upload_to', $this->viewData['filterParams']) )? $this->viewData['filterParams']['upload_to']['value']: '' ?>">
            </div>
            <input type="submit">
        </form>
    </div>
</div>