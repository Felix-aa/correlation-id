<?php

namespace Felixaa\Logger\Tests\Processor;

use Felixaa\Logger\LoggerInterface;
use PHPUnit\Framework\TestCase;
use Felixaa\Logger\Processor\CorrelationIdProcessor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\HeaderBag;



class CorrelationIdProcessorTest extends TestCase
{

    public function testCorrelationIdProcessorWithHeaderRequestCorrelationIDFound()
    {
        $headers = $this->createMock(HeaderBag::class, array('get'));
        $request = $this->createMock(Request::class);
        $requestStack = $this->createMock(RequestStack::class, array('getCurrentRequest'));
        $correlationId = '123456789';


        $headers->method('get')
            ->with(LoggerInterface::MAVIANCE_CORRELATION_ID)
            ->willReturn($correlationId);

        $request->headers = $headers;

        $requestStack->method('getCurrentRequest')
            ->willReturn($request);

        $processor = new CorrelationIdProcessor($requestStack);
        $record = $processor([]); 

        $this->assertArrayHasKey(LoggerInterface::CORRELATION_ID, $record['context']);
        $this->assertEquals($correlationId,  $record['context'][LoggerInterface::CORRELATION_ID]);

    }


}
 