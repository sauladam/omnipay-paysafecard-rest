<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\AuthorizeRequest;
use Omnipay\Paysafecard\Message\CaptureRequest;
use Omnipay\Paysafecard\Message\DetailsRequest;
use Omnipay\Paysafecard\Message\RefundRequest;
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

        $this->assertInstanceOf(AuthorizeRequest::class, $request);
    }


    /** @test */
    public function correct_request_class_for_capture_request()
    {
        $request = $this->gateway->capture();

        $this->assertInstanceOf(CaptureRequest::class, $request);
    }


    /** @test */
    public function correct_request_class_for_details_request()
    {
        $request = $this->gateway->details();

        $this->assertInstanceOf(DetailsRequest::class, $request);
    }


    /** @test */
    public function correct_request_class_for_validate_refund_request()
    {
        $request = $this->gateway->validateRefund();

        $this->assertInstanceOf(RefundRequest::class, $request);
    }


    /** @test */
    public function correct_request_class_for_refund_request()
    {
        $request = $this->gateway->refund();

        $this->assertInstanceOf(RefundRequest::class, $request);
    }


    /** @test */
    public function capture_is_set_to_false_for_validate_refund_requests()
    {
        $request = $this->gateway->validateRefund();

        $this->assertFalse($request->getData()['capture']);
    }


    /** @test */
    public function capture_is_set_to_true_for_refund_requests()
    {
        $request = $this->gateway->refund();

        $this->assertTrue($request->getData()['capture']);
    }
}
