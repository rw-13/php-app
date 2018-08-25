<?php
/*
    $sortBy = (isset($this->viewData['sortBy'])) ? ($this->viewData['sortBy']) : false;

    $flagForm = (isset($this->viewData['filterParams']) && count($this->viewData['filterParams'])) ? true : false;

    //Устанавливает сслыки в сортировке
    function setUri($flagForm, $name)
    {
        $requestUri = '';
        switch ($flagForm)
        {
            //Есть данные с формы
            case true:
                $uri = '&sort='.$name;

                $address = $_SERVER['REQUEST_URI'];     */
    //            $pattern = '/&sort[a-zA-Z]*=[a-zA-Z]*/';
 /*               $add = preg_replace($pattern, '', $address);

                $requestUri = $add.$uri;
                break;

            //Нет данных с формы
            case false:
                $requestUri = '/product/main?sort='.$name;
                break;
        }
        return $requestUri;
    }
*/
/*    function displaySortField($fieldName)
    {
        $sortSign = '';
        if (isset($_SESSION['sortBy']) && $_SESSION['sortBy']['field']==$fieldName)
        {
            switch ($_SESSION['sortBy']['type']) {
                case 'ASC':
                    $sortSign = '<i class="fa fa-caret-up" aria-hidden="true"></i>';
                    break;
                case 'DESC':
                    $sortSign = '<i class="fa fa-caret-down" aria-hidden="true"></i>';
                    break;
            }
        }
        return $sortSign;
    }*/

//    $func = $this->viewData['refUri'];
/*    print_r($func);
    echo $func($flagForm=true, $name='brand');*/

//    $refUri = (isset($this->viewData[sortBy]) && array_key_exists('refUri', $this->viewData[sortBy])) ? $this->viewData[sortBy]['refUri'] : '';
//    $refUri = (isset($this->viewData[sortBy]) && array_key_exists('refUri', $this->viewData[sortBy])) ? $this->viewData[sortBy]['refUri'] : '';
//$func = $this->viewData['sortBy']['refUri'];
//var_dump($func);
//print_r($func);
?>

    <h1>Номенклатура товаров</h1>

    <table>
        <thead>
            <th>ид</th>
            <th>артикул</th>
            <th><a href="<?= $this->viewData['sortBy']['refUri'](isset($this->viewData['filterParams']), $name='name') ?>">
                    наименование <?= $this->viewData['sortBy']['signSort']($this->viewData['sortBy'], 'name') ?></a>
            </th>
            <th><a href="<?= $this->viewData['sortBy']['refUri'](isset($this->viewData['filterParams']), $name='brand') ?>">
                    производитель<?= $this->viewData['sortBy']['signSort']($this->viewData['sortBy'], 'brand') ?></a>
            </th>
            <th>тип</th>
            <th>цвет</th>
            <th><a href="<?= $this->viewData['sortBy']['refUri'](isset($this->viewData['filterParams']), $name='price') ?>">
                    цена<?= $this->viewData['sortBy']['signSort']($this->viewData['sortBy'], 'price') ?></a>
            </th>
            <th><a href="<?= $this->viewData['sortBy']['refUri'](isset($this->viewData['filterParams']), $name='discount') ?>">
                    скидка<?= $this->viewData['sortBy']['signSort']($this->viewData['sortBy'], 'discount') ?></a>
            </th>
            <th><a href="<?= $this->viewData['sortBy']['refUri'](isset($this->viewData['filterParams']), $name='upload') ?>">
                    дата добавления товара<?= $this->viewData['sortBy']['signSort']($this->viewData['sortBy'], 'upload') ?></a>
            </th>
        </thead>
        <tbody>
        <?php foreach($this->viewData['data'] as $product):?>
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
        <?= $this->viewData['pagination']->get(); ?>
    </div>