<?php

namespace Codatte\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler;

use Codatte\Bundle\PayumMoneticoBundle\Bridge\Commerce\Action\CancelAction;
use Codatte\Bundle\PayumMoneticoBundle\Bridge\Commerce\Action\ConvertAction;
use Codatte\Bundle\PayumMoneticoBundle\Bridge\Commerce\Action\RefundAction;
use Ekyna\Component\Payum\Monetico\MoneticoGatewayFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class RegisterGatewayPass
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class RegisterGatewayPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('payum.builder')) {
            return;
        }
        $this->registerFactory($container);
        $this->registerActions($container);
    }

    /**
     * Registers the gateway factory.
     *
     * @param ContainerBuilder $container
     */
    private function registerFactory(ContainerBuilder $container)
    {
        $payumBuilder = $container->getDefinition('payum.builder');
        $payumBuilder->addMethodCall('addGatewayFactoryConfig', ['monetico_1', new Parameter('payum_monetico.api_config_1')]);
        $payumBuilder->addMethodCall('addGatewayFactory', ['monetico_1', [MoneticoGatewayFactory::class, 'build']]);
        $payumBuilder->addMethodCall('addGatewayFactoryConfig', ['monetico_2', new Parameter('payum_monetico.api_config_2')]);
        $payumBuilder->addMethodCall('addGatewayFactory', ['monetico_2', [MoneticoGatewayFactory::class, 'build']]);
    }

    /**
     * Registers actions.
     *
     * @param ContainerBuilder $container
     */
    private function registerActions(ContainerBuilder $container)
    {
        // Only for EkynaCommerceBundle
        if (!$container->hasDefinition('ekyna_commerce.payment.checkout_manager')) {
            return;
        }

        // Commerce convert payment action
        $definition = new Definition(ConvertAction::class);
        $definition->addTag('payum.action', ['factory' => 'monetico_1', 'prepend' => true]);
        $definition->addTag('payum.action', ['factory' => 'monetico_2', 'prepend' => true]);
        $container->setDefinition('ekyna_commerce.payum.action.monetico.convert_payment', $definition);

        // Commerce cancel payment action
        $definition = new Definition(CancelAction::class);
        $definition->addTag('payum.action', ['factory' => 'monetico_1']);
        $definition->addTag('payum.action', ['factory' => 'monetico_2']);
        $container->setDefinition('ekyna_commerce.payum.action.monetico.cancel', $definition);

        // Commerce refund payment action
        $definition = new Definition(RefundAction::class);
        $definition->addTag('payum.action', ['factory' => 'monetico_1']);
        $definition->addTag('payum.action', ['factory' => 'monetico_2']);
        $container->setDefinition('ekyna_commerce.payum.action.monetico.refund', $definition);
    }
}
