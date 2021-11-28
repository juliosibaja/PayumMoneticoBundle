<?php

namespace Codatte\Bundle\PayumMoneticoBundle\DependencyInjection;

use Ekyna\Component\Payum\Monetico\Api\Api;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaPayumMoneticoExtensionTest
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class EkynaPayumMoneticoExtensionTest extends TestCase
{
    public function testSetApiConfigAsContainerParameter()
    {
        $expectedApiConfig = [0 => [
            'mode'    => Api::MODE_PRODUCTION,
            'tpe'     => '1324567890',
            'key'     => '1234567890',
            'company' => 'foobar',
            'debug'   => true,
        ],
        1 => [
            'mode'    => Api::MODE_PRODUCTION,
            'tpe'     => '1324567890',
            'key'     => '1234567890',
            'company' => 'foobar',
            'debug'   => true,
        ]];

        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $container */
        $container = $this->createMock(ContainerBuilder::class);
            // ->getMockBuilder(ContainerBuilder::class)
            // ->getMock();

        $container
            ->expects($this->exactly(0))
            ->method('setParameter')
            ->withConsecutive(
                ['payum_monetico.api_config_1', $expectedApiConfig[0]],
                ['payum_monetico.api_config_2', $expectedApiConfig[1]],
        );
            
        $extension = new EkynaPayumMoneticoExtension();
        $extension->load(['payum_monetico' => $expectedApiConfig], $container);


    }
}