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
        return $this->getRefundId()
            ? []
            : [
                'type' => 'PAYSAFECARD',
                'capture' => $this->shouldCapture(),
                'amount' => $this->getAmount(),
                'currency' => $this->getCurrency(),
                'customer' => $this->getCustomerDetails(),
            ];
    }


    /**
     * Get the customer id value.
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getParameter('customerId');
    }


    /**
     * Set the customer id value.
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $value);
    }


    /**
     * Get the customer email value.
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }


    /**
     * Set the customer email value.
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }


    /**
     * Get the refund id value.
     *
     * @return string|null
     */
    public function getRefundId()
    {
        return $this->getParameter('refundId');
    }


    /**
     * Set the refund id value.
     *
     * @param string|null $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setRefundId($value)
    {
        return $this->setParameter('refundId', $value);
    }


    /**
     * Get the endpoint URL for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getRefundId()
            ? parent::getEndpoint() . "payments/{$this->getPaymentId()}/refunds/{$this->getRefundId()}/capture"
            : parent::getEndpoint() . "payments/{$this->getPaymentId()}/refunds";
    }


    /**
     * Get the customer details that are set.
     *
     * @return array
     */
    protected function getCustomerDetails()
    {
        $details = [];

        if ($email = $this->getCustomerEmail()) {
            $details['email'] = $email;
        }

        if ($id = $this->getCustomerId()) {
            $details['id'] = $id;
        }

        return $details;
    }


    /**
     * Should the refund be captured?
     *
     * @return bool
     */
    protected function shouldCapture()
    {
        return true;
    }


    /**
     * Create a response from the received data.
     *
     * @param \Guzzle\Http\Message\Response $response
     * @param string $type
     *
     * @return RefundResponse
     */
    protected function createResponse($response, $type = '')
    {
        return parent::createResponse($response, 'Refund');
    }
}
