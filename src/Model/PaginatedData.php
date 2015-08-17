<?php

namespace KieranBamforth\Bundle\PaginatorBundle\Model;

use JMS\Serializer\Annotation as JMS;

class PaginatedData
{
    private $data;
    private $dataTotal;
    private $page;
    private $maxResults;

    /**
     * @var
     */
    private $nextUrl;

    /**
     * @param $data
     * @param $dataTotal
     * @param $page
     * @param $maxResults
     *
     * @return PaginatedData
     */
    public function __construct($data, $dataTotal, $page, $maxResults)
    {
        $this->data = $data;
        $this->dataTotal = $dataTotal;
        $this->page = $page;
        $this->maxResults = $maxResults;
    }
}
