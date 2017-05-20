<?php

namespace Omnipay\Paysafecard\Message;

class RefundRequest extends AbstractRequest
{

    /**
     * Get the raw data for this request.
     *
     * @return array
     */
    public function getData()
    {
        return [
            'type' => 'PAYSAFECARD',
            'capture' => !$this->getOnlyValidate(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
        ];
    }


    /**
     * Get the only validate value.
     *
     * @return boolean
     */
    public function getOnlyValidate()
    {
        return $this->getParameter('onlyValidate');
    }


    /**
     * Set the only validate value.
     *
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setOnlyValidate($value)
    {
        return $this->setParameter('onlyValidate', $value);
    }


    /**
     * Get the endpoint URL for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . 'payments/' . $this->getPaymentId() . '/refunds';
    }
}
