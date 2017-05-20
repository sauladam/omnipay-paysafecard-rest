<?php

namespace Omnipay\Paysafecard;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Paysafecard\Message\CaptureRequest;
use Omnipay\Paysafecard\Message\Response;

class CaptureRequestTest extends \Omnipay\Tests\TestCase
{
    /** @var  CaptureRequest */
    public $request;


    public function setUp()
    {
        parent::setUp();

        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());
    }


    /** @test */
    public function it_sets_the_data_correctly()
    {
        $this->request->setPaymentId('some-payment-id');

        $this->assertEquals('some-payment-id', $this->request->getPaymentId());
    }


    /** @test */
    public function it_returns_the_correct_test_endpoint_url()
    {
        $this->request->setTestMode(true);
        $this->request->setPaymentId('some-payment-id');

        $this->assertEquals(
            'https://apitest.paysafecard.com/v1/payments/some-payment-id/capture',
            $this->request->getEndpoint()
        );
    }


    /** @test */
    public function it_returns_the_correct_live_endpoint_url()
    {
        $this->request->setTestMode(false);
        $this->request->setPaymentId('some-payment-id');

        $this->assertEquals(
            'https://api.paysafecard.com/v1/payments/some-payment-id/capture',
            $this->request->getEndpoint()
        );
    }


    /** @test */
    public function it_checks_if_an_api_key_is_set_before_sending()
    {
        try {
            $this->request->send();
        } catch (InvalidRequestException $e) {
            return;
        }

        $this->fail("No Exception thrown even though the API key is not set.");
    }


    /** @test */
    public function it_uses_the_correct_http_method()
    {
        $this->assertEquals('POST', $this->request->httpMethod());
    }


    /** @test */
    public function it_returns_the_correct_response_type()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');

        $response = $this->request->setApiKey('some-key')->send();

        $this->assertInstanceOf(Response::class, $response);
    }
}
