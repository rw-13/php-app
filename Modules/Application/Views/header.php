<div id="header-top">
    <div id="left-block">
        <a href="/product/main">К списку товаров</a>
        <a href="/product/fill">Сгенерировать +1000 записей</a>
        <br><br>
    </div>
    <div id="right-block">
        <?php if(isset($filter) && !empty($filter)) require_once ($filter); ?>
    </div>
</div>