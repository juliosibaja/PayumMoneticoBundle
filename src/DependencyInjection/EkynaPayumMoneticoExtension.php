<?php

namespace Codatte\Bundle\PayumMoneticoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class EkynaPayumMoneticoExtension
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class EkynaPayumMoneticoExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Api Config
        $container->setParameter('payum_monetico.api_config_1', $config['api']['monetico_1']);
        $container->setParameter('payum_monetico.api_config_2', $config['api']['monetico_2']);
    }
}
