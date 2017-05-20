<?php

namespace Omnipay\Paysafecard;

use Omnipay\Common\AbstractGateway;

class RestGateway extends AbstractGateway
{
    /**
     * Get the name
     *
     * @return string
     */
    public function getName()
    {
        return 'Paysafecard REST';
    }


    /**
     * Get the default parameters.
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'apiKey' => '',
            'testMode' => true,

        ];
    }


    /**
     * Get the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }


    /**
     * Set the API key.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }


    /**
     * Authorize the payment.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function authorize(array $options = array())
    {
        return $this->createRequest('\Omnipay\Paysafecard\Message\AuthorizeRequest', $options);
    }


    /**
     * Capture the payment.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function capture(array $options = array())
    {
        return $this->createRequest('\Omnipay\Paysafecard\Message\CaptureRequest', $options);
    }


    /**
     * Get the payment details.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function details(array $options = array())
    {
        return $this->createRequest('\Omnipay\Paysafecard\Message\DetailsRequest', $options);
    }


    /**
     * Validate the refund.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function validateRefund(array $options = array())
    {
        $options = array_merge($options, ['onlyValidate' => true]);

        return $this->createRequest('\Omnipay\Paysafecard\Message\RefundRequest', $options);
    }


    /**
     * Refund the payment.
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function refund(array $options = array())
    {
        $options = array_merge($options, ['onlyValidate' => false]);

        return $this->createRequest('\Omnipay\Paysafecard\Message\RefundRequest', $options);
    }
}
