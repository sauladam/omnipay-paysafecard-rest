<?php

namespace Omnipay\Paysafecard\Message;

use Guzzle\Http\ClientInterface;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.paysafecard.com/v1/';

    /**
     * @var string
     */
    protected $testEndpoint = 'https://apitest.paysafecard.com/v1/';


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
     * Get the payment id.
     *
     * @return string
     */
    public function getPaymentId()
    {
        return $this->getParameter('paymentId');
    }


    /**
     * Set the payment id.
     *
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setPaymentId($value)
    {
        return $this->setParameter('paymentId', $value);
    }


    /**
     * Send the request with specified data
     *
     * @param  array $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $this->validate('apiKey');

        $this->allowFailureHttpStatusCodes();

        $headers = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Basic ' . base64_encode($this->getApiKey()),
        ];

        $request = $this->httpMethod() == 'POST'
            ? $this->httpClient->post($this->getEndpoint(), $headers, json_encode($data))
            : $this->httpClient->get($this->getEndpoint(), $headers);

        $response = $request->send();

        return $this->createResponse($response);
    }


    /**
     * Stop exception propagation for HTTP status codes that may contain
     * error descriptions.
     */
    public function allowFailureHttpStatusCodes()
    {
        $this->httpClient
            ->getEventDispatcher()
            ->addListener('request.error', function (\Guzzle\Common\Event $event) {
                if (in_array($event['response']->getStatusCode(), [400, 401, 404, 500, 501, 502, 503, 504])) {
                    $event->stopPropagation();
                }
            });
    }


    /**
     * Get the HTTP method for this request.
     *
     * @return string
     */
    public function httpMethod()
    {
        return 'POST';
    }


    /**
     * Get the API endpoint URL.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getTestMode()
            ? $this->testEndpoint
            : $this->liveEndpoint;
    }


    /**
     * Create the response.
     *
     * @param \Guzzle\Http\Message\Response $response
     * @param string $type
     *
     * @return Response
     */
    protected function createResponse($response, $type = '')
    {
        $responseClassName = '\Omnipay\Paysafecard\Message\\' . $type . 'Response';

        return $this->response = new $responseClassName($this, $response->json(), $response->getStatusCode());
    }
}
