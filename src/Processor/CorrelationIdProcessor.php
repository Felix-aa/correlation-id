<?php

/*
 * @author Felix Ashu Aba
 *
 */

namespace Felixaa\Logger\Processor;

use Felixaa\Logger\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RequestStack;


class CorrelationIdProcessor implements LoggerInterface
{

    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {

       $this->requestStack = $requestStack;

    }

    public function __invoke(array $record): array
    {
        $request = $this->requestStack->getCurrentRequest();
        
        if (!$request) {
            return $record;
        }

        if (!$request->headers) {
            return $record;
        }

        $correlationId = $request->headers->get(self::MAVIANCE_CORRELATION_ID) ?? Uuid::uuid4();

        $record['extra'][self::CORRELATION_ID] = $correlationId;
        $request->headers->set(self::MAVIANCE_CORRELATION_ID, $correlationId);

        return $record;
    }
}
