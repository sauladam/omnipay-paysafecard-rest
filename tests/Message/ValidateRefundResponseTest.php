<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\RefundResponse;

class ValidateRefundResponseTest extends \Omnipay\Tests\TestCase
{
    /** @test */
    public function get_the_refund_id()
    {
        $response = $this->mockResponseFrom('ValidateRefundSuccess.txt');

        $this->assertEquals(
            'ref_1020007509_3WklNy9C2IykI8w08eBgWt5UsWyHr5kg_EUR',
            $response->getRefundId()
        );
    }


    /** @test */
    public function get_the_status()
    {
        $response = $this->mockResponseFrom('ValidateRefundSuccess.txt');

        $this->assertEquals(
            'VALIDATION_SUCCESSFUL',
            $response->getStatus()
        );
    }


    /** @test */
    public function get_the_resource_object_type()
    {
        $response = $this->mockResponseFrom('ValidateRefundSuccess.txt');

        $this->assertEquals('REFUND', $response->getObject());
    }


    /** @test */
    public function get_the_message()
    {
        $response = $this->mockResponseFrom('ValidateRefundFailure.txt');

        $this->assertEquals(
            '{"code":"invalid_request_parameter","message":"may not be null","number":10028,"param":"customer.id"}',
            $response->getMessage()
        );
    }


    /** @test */
    public function correct_http_response_status()
    {
        $successResponse = $this->mockResponseFrom('ValidateRefundSuccess.txt');
        $failResponse = $this->mockResponseFrom('ValidateRefundFailure.txt');

        $this->assertEquals(201, $successResponse->responseCode);
        $this->assertEquals(400, $failResponse->responseCode);
    }


    /** @test */
    public function correct_transaction_status()
    {
        $successResponse = $this->mockResponseFrom('ValidateRefundSuccess.txt');
        $failResponse = $this->mockResponseFrom('ValidateRefundFailure.txt');

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
