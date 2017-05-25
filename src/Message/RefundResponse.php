<?php

namespace Omnipay\Paysafecard\Message;

class RefundResponse extends Response
{
    /**
     * Get the refund transaction id.
     *
     * @return string
     */
    public function getRefundId()
    {
        return $this->data['id'];
    }
}
