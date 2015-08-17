<?php

namespace KieranBamforth\Bundle\PaginatorBundle\Paginators;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Functional as F;

class DoctrinePaginatorAdapter implements  PaginatorInterface
{
    private $data;
    private $dataTotal;

    public function __construct(Paginator $data, $dataTotal)
    {
        $this->data = $data;
        $this->dataTotal = $dataTotal;
    }

    public function getData()
    {
        return F\map($this->data->getIterator(), function($entry) {
            return $entry;
        });
    }

    public function getDataTotal()
    {
        return $this->dataTotal;
    }
}
