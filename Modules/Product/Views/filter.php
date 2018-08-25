<?php
    function sortByKey($array, $key)
    {
        print 'Data before';
        var_dump($array);
        var_dump($array[0]['name']);
        echo '</br>';

/*        if (array_multisort($array[0], SORT_ASC))
        {
            var_dump($array);
        } else {
            echo 'sort error';
        }*/

        $products = [];
        $count = sizeof($array)-1;
        for ($i=0; $i < $count; $i++)
        {
            if ((strnatcasecmp($array[$i][$key], $array[$i+1][$key]) > 0))
            {
                $temp = $array[$i][$key];
                $array[$i][$key] = $array[$i+1][$key];
                $array[$i+1][$key] = $temp;
            }
        }

        print 'Data after sort ';
        var_dump($array);
        //var_dump($array[]);
    }

    sortByKey($this->viewData['data'], 'name');
?>


<table>
    <thead>
        <th>ид</th>
        <th>артикул</th>
        <th><a href=" ">наименование</a></th>
        <th><a href="/product/list?field=brand&sorting=ASC&page=1">производитель</th>
        <th>тип</th>
        <th>цвет</th>
        <th><a href="/product/list?field=price&sorting=ASC&page=1">цена</th>
        <th><a href="/product/list?field=discount&sorting=ASC&page=1">скидка</th>
        <th><a href="/product/list?field=upload&sorting=ASC&page=1">дата добавления товара</th>
    </thead>
    <tbody>

        <?php foreach($this->viewData['data'] as $product): ?>
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
        <?php endforeach; ?>
    
    </tbody>
</table>

<div id="pagination">
    <?= $this->viewData['pagination']->get(); ?>
</div>
