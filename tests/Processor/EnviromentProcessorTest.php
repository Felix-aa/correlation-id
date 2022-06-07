<?php

namespace Felixaa\Logger\Tests\Processor;

use PHPUnit\Framework\TestCase;
use Felixaa\Logger\Processor\EnviromentProcessor;

class EnviromentProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEnviroment()
    {
        $processor = new EnviromentProcessor("dev");
        $record = $processor([]);

        $this->assertArrayHasKey('enviroment', $record['extra']);
        $this->assertEquals('dev',$record['extra']['enviroment']);
    }


}
 