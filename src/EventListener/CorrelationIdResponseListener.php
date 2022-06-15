<?php

namespace Felixaa\Logger\EventListener;

use Felixaa\Logger\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;


class CorrelationIdResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$request) {
            return;
        }
        
        if (!$request->headers) {
            return;
        }
        $correlationId = $request->headers->get(LoggerInterface::MAVIANCE_CORRELATION_ID);
    
        $response = $event->getResponse();
        
        if(!empty($response) && !empty($correlationId)){
            $response->headers->set(LoggerInterface::MAVIANCE_CORRELATION_ID, $correlationId);
        }
    }
}
