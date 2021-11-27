<?php

namespace Codatte\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler;

use Ekyna\Component\Payum\Monetico\MoneticoGatewayFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;

/**
 * Class RegisterGatewayPassTest
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class RegisterGatewayPassTest extends TestCase
{
    public function testProcess()
    {
        #/** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $container */
        $container = $this->createMock(ContainerBuilder::class);
        
        // $container->getMock();
        // var_dump($container->getMock());
        // $container = $container->getMock();
        // var_dump(get_class_methods($container));


        /** @var \PHPUnit_Framework_MockObject_MockObject|Definition $definition */
        $definition = $this
            ->createMock(Definition::class);
            // ->getMock();

        // $definition
        // ->expects($this->exactly(0))
        // ->method('addMethodCall')
        // ->with();

        $definition
        // ->expects($this->exactly(1))
        ->method('addMethodCall')
        ->withConsecutive(
            ['addGatewayFactoryConfig', ['monetico_1', new Parameter('payum_monetico.api_config_1')]],
            ['addGatewayFactory', ['monetico_1', [MoneticoGatewayFactory::class, 'build']]]
        );


    $container
            // ->expects($this->exactly(0))
            ->method('hasDefinition')
            ->withConsecutive(['payum.builder'], ['ekyna_commerce.payment.checkout_manager'])
            ->willReturn(true);

        $container
            // ->expects($this->exactly(1))
            ->method('getDefinition')
            ->with('payum.builder')
            ->willReturn($definition);


        $pass = new RegisterGatewayPass();
        $pass->process($container);
    }
}
