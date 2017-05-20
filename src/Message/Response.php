<?php

namespace Omnipay\Paysafecard\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    /**
     * @var int
     */
    public $responseCode;


    /**
     * Response constructor.
     *
     * @param RequestInterface $request
     * @param array $data
     * @param int $responseCode
     */
    public function __construct(RequestInterface $request, $data, $responseCode)
    {
        parent::__construct($request, $data);

        $this->responseCode = $responseCode;
    }


    /**
     * Get the object type of the returned resource. Should be
     * 'payment' or 'refund'.
     *
     * @return string
     */
    public function getObject()
    {
        return $this->data['object'];
    }


    /**
     * Get the payment id.
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->data['id'];
    }


    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->responseCode < 400;
    }


    /**
     * Get the transaction status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }


    /**
     * Get the response data as JSON.
     *
     * @return string
     */
    public function getMessage()
    {
        return json_encode($this->data);
    }
}
