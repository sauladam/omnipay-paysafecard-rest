<?php

namespace Omnipay\Paysafecard\Message;

class CaptureRequest extends AbstractRequest
{
    /**
     * Get the raw data for this request.
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }


    /**
     * Get the endpoint URL for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . "payments/{$this->getPaymentId()}/capture";
    }
}
