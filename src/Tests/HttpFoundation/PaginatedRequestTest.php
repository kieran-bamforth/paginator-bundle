<?php

namespace KieranBamforth\Bundle\PaginatorBundle\Tests\HttpFoundation;

use KieranBamforth\Bundle\PaginatorBundle\Paginators\PaginatorInterface;
use KieranBamforth\Bundle\PaginatorBundle\Model\PaginatedData;
use KieranBamforth\Bundle\PaginatorBundle\HttpFoundation\PaginatedRequest;
use Symfony\Component\HttpFoundation\Request;

class PaginatedRequestTest extends \PHPUnit_Framework_TestCase
{
    private $pagePath;
    private $pageDefaultValue;
    private $maxResultsPath;
    private $maxResultsDefaultValue;
    private $mockRequest;
    private $paginatedRequest;

    public function setUp()
    {
        parent::setUp();
        $this->pagePath = 'pagePath';
        $this->pageDefaultValue = 1;
        $this->maxResultsPath = 'maxResultsPath';
        $this->maxResultsDefaultValue = 10;
        $this->mockRequest = new Request(
                [],
                [],
                [],
                [],
                [],
                [],
                'content'
        );
        $this->paginatedRequest = \Mockery::mock(
            'KieranBamforth\Bundle\PaginatorBundle\HttpFoundation\PaginatedRequest[getPage,getMaxResults]',
            [
                $this->mockRequest,
                $this->pagePath,
                $this->pageDefaultValue,
                $this->maxResultsPath,
                $this->maxResultsDefaultValue
            ]
        );
        $this->paginatedRequest->shouldReceive('getPage')->andReturn($this->pageDefaultValue)->byDefault();
        $this->paginatedRequest->shouldReceive('getMaxResults')->andReturn($this->maxResultsPath)->byDefault();
    }

    public function getMockBag()
    {
        return \Mockery::mock(
            'Symfony\Component\HttpFoundation\ParameterBag',
            ['all'=> true]
        );
    }

    public function testGetPage()
    {
        $this->markTestSkipped();
    }

    public function testGetMaxResults()
    {
        $this->markTestSkipped();
    }

    /**
     * @dataProvider getOffsetDataProvider
     */
    public function testGetOffset($expected, $page, $perpage)
    {
        $this->paginatedRequest->shouldReceive('getPage')->andReturn($page);
        $this->paginatedRequest->shouldReceive('getMaxResults')->andReturn($perpage);
        $this->assertEquals(
            $expected,
            $this->paginatedRequest->getOffset()

        );
    }

    public function getOffsetDataProvider()
    {
        return [
            [0, 1, 1],
            [1, 2, 1],
            [2, 3, 1],
            [3, 4, 1],
            [0, 1, 2],
            [2, 2, 2],
            [4, 3, 2],
            [6, 4, 2],
            [0, 1, 10],
            [10, 2, 10],
            [20, 3, 10],
            [30, 4, 10],
        ];
    }

    public function testGetPaginatedData()
    {
        $this->markTestSkipped();
    }
}
