<?php

    //$navigation = $this->viewData['navigation'];
    $fieldname = $this->viewData['fieldname'];
    $sorting = $this->viewData['sorting'];
    $products = $this->viewData['data'];
    $pagination = $this->viewData['pagination'];
    //$filter = $this->viewData['filter_form'];


    //Возвращает порядок сортировки $reference - ссылка в html, $fieldname, $sorting - данные из URL
    function invokeSorting($reference, $fieldname, $sorting) {
        if ($fieldname===$reference) {
            return ($sorting === 'ASC') ? 'DESC' : 'ASC';
        } else {
            return 'ASC';
        }
    }

    //Возвращает порядок сортировки $reference - ссылка в html, $fieldname, $sorting - данные из URL
    function generateHtmlSorting($reference, $fieldname, $sorting) {
        $sortAsc = '<i class="fa fa-caret-up" aria-hidden="true"></i>';
        $sortDesc = '<i class="fa fa-caret-down" aria-hidden="true"></i>';

        if ($fieldname===$reference) {
            switch ($sorting) {
                case 'ASC':
                    echo $sortAsc;
                    break;
                case 'DESC':
                    echo $sortDesc;
                    break;
            }
        }
    }

?>

<h1>Номенклатура товаров</h1>

<table>
    <thead>
    <th>ид</th>
    <th>артикул</th>
    <th><a href="?field=name&sorting=<?= invokeSorting($reference='name', $fieldname, $sorting) ?>&page=1">наименование <?= generateHtmlSorting($reference, $fieldname, $sorting) ?></a></th>
    <th><a href="?field=brand&sorting=<?= invokeSorting($reference='brand', $fieldname, $sorting) ?>&page=1">производитель <?= generateHtmlSorting($reference, $fieldname, $sorting) ?></a></th>
    <th>тип</th>
    <th>цвет</th>
    <th><a href="?field=price&sorting=<?= invokeSorting($reference='price', $fieldname, $sorting) ?>&page=1">цена <?= generateHtmlSorting($reference, $fieldname, $sorting) ?></a></th>
    <th><a href="?field=discount&sorting=<?= invokeSorting($reference='discount', $fieldname, $sorting) ?>&page=1">скидка <?= generateHtmlSorting($reference, $fieldname, $sorting) ?></a></th>
    <th><a href="?field=upload&sorting=<?= invokeSorting($reference='upload', $fieldname, $sorting) ?>&page=1">дата добавления товара <?= generateHtmlSorting($reference, $fieldname, $sorting) ?></a></th>
    </thead>
    <tbody>
    <?php foreach($products as $product):?>
        <tr>
            <td><?= $product['id']; ?></td>
            <td><?= $product['articul']; ?></td>
            <td><?= $product['name']; ?></td>
            <td><?= $product['brand']; ?></td>
            <td><?= $product['type']; ?></td>
            <td><?= $product['color']; ?></td>
            <td><?= $product['price']; ?></td>
            <td><?= $product['discount']; ?></td>
            <td><?= $product['upload']; ?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<div id="pagination">
    <?= $pagination->get(); ?>
</div>
