<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\RefundResponse;

class RefundResponseTest extends \Omnipay\Tests\TestCase
{
    /** @test */
    public function get_the_refund_id()
    {
        $response = $this->mockResponseFrom('RefundSuccess.txt');

        $this->assertEquals(
            'ref_1020007509_y7bTCJL8Rkwxm34u2EdSEGGCJ0X5kAXc_EUR',
            $response->getRefundId()
        );
    }


    /** @test */
    public function get_the_status()
    {
        $response = $this->mockResponseFrom('RefundSuccess.txt');

        $this->assertEquals(
            'SUCCESS',
            $response->getStatus()
        );
    }


    /** @test */
    public function get_the_resource_object_type()
    {
        $response = $this->mockResponseFrom('RefundSuccess.txt');

        $this->assertEquals('REFUND', $response->getObject());
    }


    /** @test */
    public function get_the_message()
    {
        $response = $this->mockResponseFrom('RefundFailure.txt');

        $this->assertEquals(
            '{"code":"merchant_refund_exceeds_original_transaction","message":"Merchant refund exceeds original transaction","number":3179}',
            $response->getMessage()
        );
    }


    /** @test */
    public function correct_http_response_status()
    {
        $successResponse = $this->mockResponseFrom('RefundSuccess.txt');
        $failResponse = $this->mockResponseFrom('RefundFailure.txt');

        $this->assertEquals(201, $successResponse->responseCode);
        $this->assertEquals(400, $failResponse->responseCode);
    }


    /** @test */
    public function correct_transaction_status()
    {
        $successResponse = $this->mockResponseFrom('RefundSuccess.txt');
        $failResponse = $this->mockResponseFrom('RefundFailure.txt');

        $this->assertTrue($successResponse->isSuccessful());
        $this->assertFalse($failResponse->isSuccessful());
    }


    /**
     * Create a mock response from the given filename.
     *
     * @param $filename
     *
     * @return RefundResponse
     */
    protected function mockResponseFrom($filename)
    {
        $httpResponse = $this->getMockHttpResponse($filename);

        return new RefundResponse($this->getMockRequest(), $httpResponse->json(), $httpResponse->getStatusCode());
    }
}
