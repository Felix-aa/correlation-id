<?php

namespace Felixaa\Logger\Tests\EventListener;

use Felixaa\Logger\EventListener\CorrelationIdRequestListener;
use Felixaa\Logger\LoggerInterface as FelixLoggerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class CorrelationIdRequestListenerTest extends TestCase
{
    protected $headers;
    protected $request;
    protected $response;
    protected $logger;
    protected $kernel;


    protected function setUp(): void
    {
        $this->headers = $this->createMock(HeaderBag::class, array('get'));
        $this->request = $this->createMock(Request::class);
        $this->response = $this->createMock(Response::class);
        $this->logger = $this->createMock(LoggerInterface::class, array('info'));
        $this->kernel = $this->createMock(HttpKernelInterface::class);
    }

    public function testResponseListenerSuccess()
    {
        $correlationId = '1477879856';

        $this->headers->method('get')
            ->with(FelixLoggerInterface::MAVIANCE_CORRELATION_ID)
            ->willReturn($correlationId);  

        $this->request->headers = $this->headers;

        $this->logger->method('info')
                ->with('Correlation Id created', [
                    "cid" => $correlationId
                ]);

        $responselistener = new CorrelationIdRequestListener($this->logger);

        $requestEvent = new RequestEvent($this->kernel, $this->request, 200, $this->response);

        $responselistener->onKernelRequest($requestEvent);

        $this->assertEquals($correlationId, $this->request->headers->get(FelixLoggerInterface::MAVIANCE_CORRELATION_ID));

    }

}