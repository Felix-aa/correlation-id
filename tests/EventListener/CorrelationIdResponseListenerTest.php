<?php

namespace Felixaa\Logger\Tests\EventListener;

use Felixaa\Logger\EventListener\CorrelationIdResponseListener;
use Felixaa\Logger\LoggerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class CorrelationIdResponseListenerTest extends TestCase
{
    protected $headers;
    protected $request;
    protected $response;
    protected $requestStack;
    protected $filterResponseEvent;
    protected $kernel;


    protected function setUp(): void
    {
        $this->headers = $this->createMock(HeaderBag::class, array('get'));
        $this->request = $this->createMock(Request::class);
        $this->response = $this->createMock(Response::class);
        $this->requestStack = $this->createMock(RequestStack::class, array('getCurrentRequest'));
        $this->kernel = $this->createMock(HttpKernelInterface::class);
    }

    public function testResponseListenerSuccess()
    {
        $correlationId = '1477879856';

        $this->headers->method('get')
            ->with(LoggerInterface::MAVIANCE_CORRELATION_ID)
            ->willReturn($correlationId);  

        $this->request->headers = $this->headers;

        $this->requestStack->method('getCurrentRequest')
                ->willReturn($this->request);

        $listener = new CorrelationIdResponseListener($this->requestStack);

        $headers = $this->createMock(HeaderBag::class, array('set', 'get'));

        $headers->method('set')
        ->with(LoggerInterface::MAVIANCE_CORRELATION_ID, $correlationId);

        $headers->method('get')
        ->with(LoggerInterface::MAVIANCE_CORRELATION_ID)
        ->willReturn($correlationId);  

        $this->response->headers = $headers;

        $this->filterResponseEvent = new ResponseEvent($this->kernel, $this->request, 200, $this->response);
    
        $listener->onKernelResponse($this->filterResponseEvent);

        $this->assertEquals($correlationId, $this->response->headers->get(LoggerInterface::MAVIANCE_CORRELATION_ID));

    }

}
 