<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\ValidateRefundRequest;

class ValidateRefundRequestTest extends RefundRequestTest
{
    /** @var  ValidateRefundRequest */
    public $request;


    public function setUp()
    {
        parent::setUp();

        $this->request = new ValidateRefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }


    /** @test */
    public function it_sets_the_refund_id_correctly()
    {
        $this->request->setRefundId('some-refund-id');

        $this->assertNull($this->request->getRefundId());
    }


    /** @test */
    public function it_builds_the_data_structure_correctly_if_no_refund_id_is_set()
    {
        $this->request->setAmount(12.34);
        $this->request->setCurrency('EUR');
        $this->request->setCustomerId(1234);
        $this->request->setCustomerEmail('customer@email.com');

        $this->assertEquals([
            'type' => 'PAYSAFECARD',
            'amount' => 12.34,
            'currency' => 'EUR',
            'customer' => [
                'id' => 1234,
                'email' => 'customer@email.com',
            ],
            'capture' => false,
        ], $this->request->getData());
    }


    public function it_builds_the_data_structure_correctly_if_a_refund_id_is_set()
    {
        $this->request->setAmount(12.34);
        $this->request->setCurrency('EUR');
        $this->request->setCustomerId(1234);
        $this->request->setCustomerEmail('customer@email.com');
        $this->request->setRefundId('some-refund-id');

        $this->assertEquals([
            'type' => 'PAYSAFECARD',
            'amount' => 12.34,
            'currency' => 'EUR',
            'customer' => [
                'id' => 1234,
                'email' => 'customer@email.com',
            ],
            'capture' => false,
        ], $this->request->getData());
    }


    /** @test */
    public function it_returns_the_correct_response_type()
    {
        $this->setMockHttpResponse('ValidateRefundSuccess.txt');

        $response = $this->request->setApiKey('some-key')->send();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\RefundResponse", $response);
    }


    /** @test */
    public function it_returns_the_correct_test_endpoint_url_if_a_refund_id_is_set()
    {
        $this->request->setTestMode(true);
        $this->request->setPaymentId('some-payment-id');
        $this->request->setRefundId('some-refund-id');

        $this->assertEquals(
            'https://apitest.paysafecard.com/v1/payments/some-payment-id/refunds',
            $this->request->getEndpoint()
        );
    }


    /** @test */
    public function it_returns_the_correct_live_endpoint_url_if_a_refund_id_is_set()
    {
        $this->request->setTestMode(false);
        $this->request->setPaymentId('some-payment-id');
        $this->request->setRefundId('some-refund-id');

        $this->assertEquals(
            'https://api.paysafecard.com/v1/payments/some-payment-id/refunds',
            $this->request->getEndpoint()
        );
    }
}
