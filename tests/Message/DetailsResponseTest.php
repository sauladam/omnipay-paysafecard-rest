<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\DetailsResponse;

class DetailsResponseTest extends \Omnipay\Tests\TestCase
{
    /** @test */
    public function get_the_auth_url()
    {
        $response = $this->mockResponseFrom('DetailsSuccess.txt');

        $this->assertEquals(
            'https://customer.test.at.paysafecard.com/psccustomer/GetCustomerPanelServlet?mid=1020007509&mtid=pay_1020007509_SOGrqsKh0GOsH5qol4wQ2KsQXDixoFEF_EUR&amount=0.01&currency=EUR',
            $response->authUrl()
        );
    }


    /** @test */
    public function get_the_payment_id()
    {
        $response = $this->mockResponseFrom('DetailsSuccess.txt');

        $this->assertEquals(
            'pay_1020007509_SOGrqsKh0GOsH5qol4wQ2KsQXDixoFEF_EUR',
            $response->getPaymentId()
        );
    }


    /** @test */
    public function get_the_status()
    {
        $response = $this->mockResponseFrom('DetailsSuccess.txt');

        $this->assertEquals(
            'SUCCESS',
            $response->getStatus()
        );
    }


    /** @test */
    public function get_the_resource_object_type()
    {
        $response = $this->mockResponseFrom('DetailsSuccess.txt');

        $this->assertEquals('PAYMENT', $response->getObject());
    }


    /** @test */
    public function get_the_message()
    {
        $response = $this->mockResponseFrom('DetailsFailure.txt');

        $this->assertEquals(
            '{"code":"invalid_api_key","message":"Authentication failed","number":10008}',
            $response->getMessage()
        );
    }

    /** @test */
    public function correct_http_response_status()
    {
        $successResponse = $this->mockResponseFrom('DetailsSuccess.txt');
        $failResponse = $this->mockResponseFrom('DetailsFailure.txt');

        $this->assertEquals(200, $successResponse->responseCode);
        $this->assertEquals(401, $failResponse->responseCode);
    }


    /**
     * Create a mock response from the given filename.
     *
     * @param $filename
     *
     * @return DetailsResponse
     */
    protected function mockResponseFrom($filename)
    {
        $httpResponse = $this->getMockHttpResponse($filename);

        return new DetailsResponse($this->getMockRequest(), $httpResponse->json(), $httpResponse->getStatusCode());
    }
}
