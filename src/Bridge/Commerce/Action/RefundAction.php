<?php

namespace Codatte\Bundle\PayumMoneticoBundle\Bridge\Commerce\Action;

use Ekyna\Component\Commerce\Bridge\Payum\Request\GetHumanStatus;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Refund;

/**
 * Class RefundAction
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class RefundAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param Refund $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $this->gateway->execute($status = new GetHumanStatus($model));
        if ($status->isCaptured()) {
            $model['state_override'] = 'refunded';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return $request instanceof Refund
            && $request->getModel() instanceof \ArrayAccess;
    }
}
