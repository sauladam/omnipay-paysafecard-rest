<?php

namespace Omnipay\Paysafecard\Message;

class AuthorizeRequest extends AbstractRequest
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
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'redirect' => [
                'success_url' => $this->getSuccessUrl(),
                'failure_url' => $this->getFailureUrl(),
            ],
            'notification_url' => $this->getNotificationUrl(),
            'customer' => [
                'id' => $this->getCustomerId(),
            ],
        ];
    }


    /**
     * Get the success redirect URL.
     *
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->getParameter('success_url');
    }


    /**
     * Set the success redirect URL.
     *
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSuccessUrl($value)
    {
        return $this->setParameter('success_url', $value);
    }


    /**
     * Get the failure redirect URL.
     *
     * @return string
     */
    public function getFailureUrl()
    {
        return $this->getParameter('failure_url');
    }


    /**
     * Set the failure redirect URL.
     *
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setFailureUrl($value)
    {
        return $this->setParameter('failure_url', $value);
    }


    /**
     * Get the notification URL.
     *
     * @return string
     */
    public function getNotificationUrl()
    {
        return $this->getParameter('notification_url');
    }


    /**
     * Set the notification URL.
     *
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setNotificationUrl($value)
    {
        return $this->setParameter('notification_url', $value);
    }


    /**
     * Get the customer id.
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getParameter('customer_id');
    }


    /**
     * Set the customer id.
     *
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCustomerId($value)
    {
        return $this->setParameter('customer_id', $value);
    }


    /**
     * Get the endpoint URL for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . 'payments';
    }


    /**
     * Create a response from the received data.
     *
     * @param \Guzzle\Http\Message\Response $response
     * @param string $type
     *
     * @return Response
     */
    protected function createResponse($response, $type = '')
    {
        return parent::createResponse($response, 'Authorize');
    }
}
