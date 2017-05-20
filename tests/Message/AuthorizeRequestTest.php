<?php

namespace Omnipay\Paysafecard;

use Guzzle\Common\Event;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Paysafecard\Message\AuthorizeRequest;
use Omnipay\Paysafecard\Message\AuthorizeResponse;

class AuthorizeRequestTest extends \Omnipay\Tests\TestCase
{
    /** @var  AuthorizeRequest */
    public $request;


    public function setUp()
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
    }


    /** @test */
    public function it_sets_the_data_correctly()
    {
        $this->request->setCustomerId(1234);
        $this->request->setFailureUrl('http://fail.com');
        $this->request->setSuccessUrl('http://success.com');
        $this->request->setNotificationUrl('http://notify.com');

        $this->assertEquals(1234, $this->request->getCustomerId());
        $this->assertEquals('http://fail.com', $this->request->getFailureUrl());
        $this->assertEquals('http://success.com', $this->request->getSuccessUrl());
        $this->assertEquals('http://notify.com', $this->request->getNotificationUrl());
    }


    /** @test */
    public function it_builds_the_data_structure_correctly()
    {
        $this->request->setCustomerId(1234);
        $this->request->setFailureUrl('http://fail.com');
        $this->request->setSuccessUrl('http://success.com');
        $this->request->setNotificationUrl('http://notify.com');
        $this->request->setCurrency('EUR');
        $this->request->setAmount('0.01');

        $this->assertEquals([
            'type' => 'PAYSAFECARD',
            'amount' => 0.01,
            'currency' => 'EUR',
            'redirect' => [
                'success_url' => 'http://success.com',
                'failure_url' => 'http://fail.com',
            ],
            'notification_url' => 'http://notify.com',
            'customer' => [
                'id' => 1234,
            ],
        ], $this->request->getData());
    }


    /** @test */
    public function it_returns_the_correct_test_endpoint_url()
    {
        $this->request->setTestMode(true);

        $this->assertEquals('https://apitest.paysafecard.com/v1/payments', $this->request->getEndpoint());
    }


    /** @test */
    public function it_returns_the_correct_live_endpoint_url()
    {
        $this->request->setTestMode(false);

        $this->assertEquals('https://api.paysafecard.com/v1/payments', $this->request->getEndpoint());
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
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->request->setApiKey('some-key')->send();

        $this->assertInstanceOf(AuthorizeResponse::class, $response);
    }
}
