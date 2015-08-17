<?php

namespace KieranBamforth\Bundle\PaginatorBundle\Paginators;

interface PaginatorInterface
{
    public function getData();
    public function getDataTotal();
}
