<?php
/**
 * Created by PhpStorm.
 * User: Felix Ashu Aba
 * Date: 04/05/22
 * Time: 18:37
 */

namespace Felixaa\Logger\Processor;

use Felixaa\Logger\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class EnviromentProcessor implements LoggerInterface
{

    private $environment;
    /**
     * Your Service constructor.
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->environment = $kernel->getEnvironment();
    }


    public function __invoke(array $record): array
    {
        if(isset($this->environment) && !empty($this->environment)){
            $record['extra']['env'] =  $this->environment;
        }
        return $record;
    }
}
