<?php

namespace Omnipay\Paysafecard;

use Omnipay\Tests\GatewayTestCase;

class RestGatewayTest extends GatewayTestCase
{
    /** @var RestGateway */
    public $gateway;


    public function setUp()
    {
        parent::setUp();

        $this->gateway = new RestGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setApiKey('some-api-key');
    }


    /** @test */
    public function the_api_key_is_set()
    {
        $this->assertEquals('some-api-key', $this->gateway->getApiKey());
    }


    /** @test */
    public function correct_request_class_for_authorize_request()
    {
        $request = $this->gateway->authorize();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\AuthorizeRequest", $request);
    }


    /** @test */
    public function correct_request_class_for_capture_request()
    {
        $request = $this->gateway->capture();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\CaptureRequest", $request);
    }


    /** @test */
    public function correct_request_class_for_details_request()
    {
        $request = $this->gateway->details();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\DetailsRequest", $request);
    }


    /** @test */
    public function correct_request_class_for_validate_refund_request()
    {
        $request = $this->gateway->validateRefund();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\ValidateRefundRequest", $request);
    }


    /** @test */
    public function correct_request_class_for_refund_request()
    {
        $request = $this->gateway->refund();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\RefundRequest", $request);
    }
}
