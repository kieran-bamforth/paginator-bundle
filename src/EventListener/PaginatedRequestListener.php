<?php

namespace KieranBamforth\Bundle\PaginatorBundle\EventListener;

use KieranBamforth\Bundle\PaginatorBundle\HttpFoundation\PaginatedRequest;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Symfony\Component\HttpFoundation\Request;

class PaginatedRequestListener
{
    private $pagePath;
    private $pageDefaultValue;
    private $maxResultsPath;
    private $maxResultsDefaultValue;

    /**
     * @param string  $pagePath
     * @param integer $pageDefaultValue
     * @param string  $maxResultsPath
     * @param integer $maxResultsDefaultValue
     *
     * @return PaginatedRequestListener
     */
    public function __construct(
        $pagePath,
        $pageDefaultValue,
        $maxResultsPath,
        $maxResultsDefaultValue
    ) {
        $this->pagePath = $pagePath;
        $this->pageDefaultValue = $pageDefaultValue;
        $this->maxResultsPath = $maxResultsPath;
        $this->maxResultsDefaultValue = $maxResultsDefaultValue;
    }


    /**
     * @param FilterControllerEvent $event
     *
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $request = $event->getRequest();

        if (is_array($controller)) {
            $r = new \ReflectionMethod($controller[0], $controller[1]);
        } elseif (is_object($controller) && is_callable($controller, '__invoke')) {
            $r = new \ReflectionMethod($controller, '__invoke');
        } else {
            $r = new \ReflectionFunction($controller);
        }

        $this->injectPaginatedRequest($r, $request);
    }

    /**
     * @param \ReflectionFunctionAbstract $r
     * @param Request                     $request
     *
     * @return void
     */
    private function injectPaginatedRequest(\ReflectionFunctionAbstract $r, Request $request)
    {
        $paginatedRequest = new PaginatedRequest(
            $request,
            $this->pagePath,
            $this->pageDefaultValue,
            $this->maxResultsPath,
            $this->maxResultsDefaultValue
        );

        foreach ($r->getParameters() as $param) {
            if (!$param->getClass() || !$param->getClass()->isInstance($paginatedRequest)) {
                continue;
            }

            $request->attributes->set($param->getName(), $paginatedRequest);
        }
    }
}
