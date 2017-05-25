<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\Response;

class CaptureResponseTest extends \Omnipay\Tests\TestCase
{
    /** @test */
    public function get_the_payment_id()
    {
        $response = $this->mockResponseFrom('CaptureSuccess.txt');

        $this->assertEquals(
            'pay_1020007509_SOGrqsKh0GOsH5qol4wQ2KsQXDixoFEF_EUR',
            $response->getPaymentId()
        );
    }


    /** @test */
    public function get_the_status()
    {
        $response = $this->mockResponseFrom('CaptureSuccess.txt');

        $this->assertEquals(
            'SUCCESS',
            $response->getStatus()
        );
    }


    /** @test */
    public function get_the_resource_object_type()
    {
        $response = $this->mockResponseFrom('CaptureSuccess.txt');

        $this->assertEquals('PAYMENT', $response->getObject());
    }


    /** @test */
    public function get_the_message()
    {
        $response = $this->mockResponseFrom('CaptureFailure.txt');

        $this->assertEquals(
            '{"code":"invalid_api_key","message":"Authentication failed","number":10008}',
            $response->getMessage()
        );
    }


    /** @test */
    public function correct_http_response_status()
    {
        $successResponse = $this->mockResponseFrom('CaptureSuccess.txt');
        $failResponse = $this->mockResponseFrom('CaptureFailure.txt');

        $this->assertEquals(200, $successResponse->responseCode);
        $this->assertEquals(401, $failResponse->responseCode);
    }


    /** @test */
    public function correct_transaction_status()
    {
        $successResponse = $this->mockResponseFrom('CaptureSuccess.txt');
        $failResponse = $this->mockResponseFrom('CaptureFailure.txt');

        $this->assertTrue($successResponse->isSuccessful());
        $this->assertFalse($failResponse->isSuccessful());
    }


    /**
     * Create a mock response from the given filename.
     *
     * @param $filename
     *
     * @return Response
     */
    protected function mockResponseFrom($filename)
    {
        $httpResponse = $this->getMockHttpResponse($filename);

        return new Response($this->getMockRequest(), $httpResponse->json(), $httpResponse->getStatusCode());
    }
}
