<?php

namespace Omnipay\Paysafecard;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Paysafecard\Message\RefundRequest;

class RefundRequestTest extends \Omnipay\Tests\TestCase
{
    /** @var  RefundRequest */
    public $request;


    public function setUp()
    {
        parent::setUp();

        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }


    /** @test */
    public function it_sets_the_data_correctly()
    {
        $this->request->setPaymentId('some-payment-id');
        $this->request->setAmount(12.34);
        $this->request->setCurrency('EUR');
        $this->request->setCustomerId(1234);
        $this->request->setCustomerEmail('customer@email.com');

        $this->assertEquals('some-payment-id', $this->request->getPaymentId());
        $this->assertEquals(12.34, $this->request->getAmount());
        $this->assertEquals('EUR', $this->request->getCurrency());
        $this->assertEquals(1234, $this->request->getCustomerId());
        $this->assertEquals('customer@email.com', $this->request->getCustomerEmail());
    }


    /** @test */
    public function it_sets_the_refund_id_correctly()
    {
        $this->request->setRefundId('some-refund-id');

        $this->assertEquals('some-refund-id', $this->request->getRefundId());
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
            'capture' => true,
        ], $this->request->getData());
    }


    /** @test */
    public function it_builds_the_data_structure_correctly_if_a_refund_id_is_set()
    {
        $this->request->setAmount(12.34);
        $this->request->setCurrency('EUR');
        $this->request->setCustomerId(1234);
        $this->request->setCustomerEmail('customer@email.com');

        $this->request->setRefundId('some-refund-id');

        $this->assertEmpty($this->request->getData());
    }


    /** @test */
    public function it_returns_the_correct_test_endpoint_url_if_no_refund_id_is_set()
    {
        $this->request->setTestMode(true);
        $this->request->setPaymentId('some-payment-id');

        $this->assertEquals(
            'https://apitest.paysafecard.com/v1/payments/some-payment-id/refunds',
            $this->request->getEndpoint()
        );
    }


    /** @test */
    public function it_returns_the_correct_test_endpoint_url_if_a_refund_id_is_set()
    {
        $this->request->setTestMode(true);
        $this->request->setPaymentId('some-payment-id');
        $this->request->setRefundId('some-refund-id');

        $this->assertEquals(
            'https://apitest.paysafecard.com/v1/payments/some-payment-id/refunds/some-refund-id/capture',
            $this->request->getEndpoint()
        );
    }


    /** @test */
    public function it_returns_the_correct_live_endpoint_url_if_no_refund_id_is_set()
    {
        $this->request->setTestMode(false);
        $this->request->setPaymentId('some-payment-id');

        $this->assertEquals(
            'https://api.paysafecard.com/v1/payments/some-payment-id/refunds',
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
            'https://api.paysafecard.com/v1/payments/some-payment-id/refunds/some-refund-id/capture',
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
        $this->setMockHttpResponse('RefundSuccess.txt');

        $response = $this->request->setApiKey('some-key')->send();

        $this->assertInstanceOf("Omnipay\Paysafecard\Message\RefundResponse", $response);
    }
}
