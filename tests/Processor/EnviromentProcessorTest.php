<?php

namespace Felixaa\Logger\Tests\Processor;

use PHPUnit\Framework\TestCase;
use Felixaa\Logger\Processor\EnviromentProcessor;
use Symfony\Component\HttpKernel\KernelInterface;

class EnviromentProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEnviroment()
    {
        $Kernel  = $this->createMock(KernelInterface::class);
        $Kernel->method('getEnvironment')
            ->willReturn('dev');


        $processor = new EnviromentProcessor($Kernel);
        $record = $processor([]);

        $this->assertArrayHasKey('env', $record['extra']);
        $this->assertEquals('dev',$record['extra']['env']);
    }


}
 