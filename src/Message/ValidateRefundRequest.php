<?php

namespace Omnipay\Paysafecard\Message;

class ValidateRefundRequest extends RefundRequest
{
    /**
     * Should the refund be captured?
     *
     * @return bool
     */
    protected function shouldCapture()
    {
        return false;
    }


    /**
     * The refund id must not be set on a validate request.
     *
     * @return null
     */
    public function getRefundId()
    {
        return null;
    }
}
