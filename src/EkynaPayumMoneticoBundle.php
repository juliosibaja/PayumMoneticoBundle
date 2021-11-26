<?php

namespace Codatte\Bundle\PayumMoneticoBundle;

use Codatte\Bundle\PayumMoneticoBundle\DependencyInjection\Compiler\RegisterGatewayPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaPayumMoneticoBundle
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class EkynaPayumMoneticoBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterGatewayPass());
    }
}
