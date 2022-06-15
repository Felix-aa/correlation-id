<?php

namespace Felixaa\Logger\EventListener;

use Felixaa\Logger\LoggerInterface as FelixLoggerInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class CorrelationIdRequestListener
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(RequestEvent $event)
    {

        if (!$event->isMainRequest()) {
            return;
        }
        
        $request = $event->getRequest();

        if (!$request->headers) {
            return;
        }
        $correlationId = $request->headers->get(FelixLoggerInterface::MAVIANCE_CORRELATION_ID) ?? Uuid::uuid4()->toString();
        
        $request->headers->set(FelixLoggerInterface::MAVIANCE_CORRELATION_ID, $correlationId);
        $this->logger->info(FelixLoggerInterface::CREATED_CORRELATION_ID, [
            FelixLoggerInterface::CORRELATION_ID => $correlationId
        ]);
    }
}
