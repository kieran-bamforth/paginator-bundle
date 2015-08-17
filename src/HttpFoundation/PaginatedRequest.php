<?php

namespace KieranBamforth\Bundle\PaginatorBundle\HttpFoundation;

use KieranBamforth\Bundle\PaginatorBundle\Exception\PaginatedDataOutOfRangeException;
use KieranBamforth\Bundle\PaginatorBundle\Model\PaginatedData;
use KieranBamforth\Bundle\PaginatorBundle\Paginators\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PaginatedRequest extends Request
{
    private $pagePath;
    private $pageDefaultValue;
    private $maxResultsPath;
    private $maxResultsDefaultValue;

    /**
     * @param Request $originalRequest
     * @param string  $pagePath
     * @param integer $pageDefaultValue
     * @param string  $maxResultsPath
     * @param integer $maxResultsDefaultValue
     *
     * @return PaginatedRequest
     */
    public function __construct(
        Request $originalRequest,
        $pagePath,
        $pageDefaultValue,
        $maxResultsPath,
        $maxResultsDefaultValue
    ) {
        parent::__construct(
            $originalRequest->query->all(),
            $originalRequest->request->all(),
            $originalRequest->attributes->all(),
            $originalRequest->cookies->all(),
            $originalRequest->files->all(),
            $originalRequest->server->all(),
            $originalRequest->getContent()
        );

        $this->pagePath = $pagePath;
        $this->pageDefaultValue = $pageDefaultValue;
        $this->maxResultsPath = $maxResultsPath;
        $this->maxResultsDefaultValue = $maxResultsDefaultValue;
    }

    /**
     * @return integer
     */
    public function getPage()
    {
        return $this->query->get(
            $this->pagePath,
            $this->pageDefaultValue
        );
    }

    /**
     * @return integer
     */
    public function getMaxResults()
    {
        return $this->query->get(
            $this->maxResultsPath,
            $this->maxResultsDefaultValue
        );
    }

    /**
     * @return integer
     */
    public function getOffset()
    {
        return ($this->getPage() - 1) * ($this->getMaxResults());
    }

    /**
     * @param PaginatorInterface $paginator
     *
     * @return PaginatedData
     */
    public function getPaginatedData(PaginatorInterface $paginator)
    {
        if ($this->getOffset() >= $paginator->getDataTotal()) {
            throw new PaginatedDataOutOfRangeException();
        }

        return new PaginatedData(
            $paginator->getData(),
            $paginator->getDataTotal(),
            $this->getPage(),
            $this->getMaxResults()
        );
    }
}
