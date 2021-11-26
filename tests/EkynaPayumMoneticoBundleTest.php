<?php

namespace Codatte\Bundle\PayumMoneticoBundle;

use Codatte\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler\RegisterGatewayPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaPayumMoneticoBundleTest
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class EkynaPayumMoneticoBundleTest extends TestCase
{
    public function testRegisterGatewayPassToContainerBuilder()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $container */
        $container = $this->createMock(ContainerBuilder::class);
            // ->getMock();

        $container
            ->expects($this->exactly(0))
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(RegisterGatewayPass::class));

        $bundle = new EkynaPayumMoneticoBundle();
        $bundle->build($container);
    }
}
