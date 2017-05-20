<?php

namespace Omnipay\Paysafecard\Message;

class DetailsRequest extends AbstractRequest
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
        return parent::getEndpoint() . "payments/{$this->getPaymentId()}";
    }


    /**
     * Get the HTTP method for this request.
     *
     * @return string
     */
    public function httpMethod()
    {
        return 'GET';
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
        return parent::createResponse($response, 'Details');
    }
}
