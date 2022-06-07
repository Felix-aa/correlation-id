<?php
/**
 * Created by PhpStorm.
 * User: Felix Ashu Aba
 * Date: 04/05/22
 * Time: 18:37
 */

namespace Felixaa\Logger\Processor;

use Felixaa\Logger\LoggerInterface;

class EnviromentProcessor implements LoggerInterface
{
    private $enviroment;

    public function __construct(string $enviroment)
    {
        $this->enviroment = $enviroment;
    }


    public function __invoke(array $record): array
    {
        if(isset($this->enviroment) && !empty($this->enviroment)){
            $record['extra']['enviroment'] =  $this->enviroment;
        }
        return $record;
    }
}
