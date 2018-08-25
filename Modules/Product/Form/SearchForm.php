<?php

namespace Modules\Product\Form;

class SearchForm
{
    private $filterParams;
    private $available = [
        'name' => [
            'type' => 'like',
        ],
        'type' => [
            'type' => 'like',
        ],
        'brand'  => [
            'type' => 'like',
        ],
        'price_from' => [
            'type' => 'from',
        ],
        'price_to' => [
            'type' => 'to',
        ],
        'upload_from' => [
            'type' => 'from',
        ],
        'upload_to' => [
            'type' => 'to',
        ],
    ];

    public function setFilterParams($filter)
    {
        // проверяем, есть ли в доступных, если есть сеттим в filterParams
        $result = false;
        foreach ($filter as $param => $value)
        {
            if (array_key_exists($param, $this->available) && $value)
            {
                $this->filterParams[$param] = [
                    'value'=> $value,
                    'meta' => $this->available[$param]
                ];
                $result = true;
            }
        }
        return $result;
    }

    public function getFilterParams()
    {
        return $this->filterParams;
    }

    public function emptyFilterParams()
    {
        if (empty($this->getFilterParams()))
            return 1;
        return -1;
    }
}