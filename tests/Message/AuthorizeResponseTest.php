<?php

namespace Omnipay\Paysafecard;

use Omnipay\Paysafecard\Message\AuthorizeResponse;

class AuthorizeResponseTest extends \Omnipay\Tests\TestCase
{
    /** @test */
    public function get_the_auth_url()
    {
        $response = $this->mockResponseFrom('AuthorizeSuccess.txt');

        $this->assertEquals(
            'https://customer.test.at.paysafecard.com/psccustomer/GetCustomerPanelServlet?mid=1020007509&mtid=pay_1020007509_MSVdaKT5EVjVtmlmFAjYF3arsUazxz3n_EUR&amount=0.01&currency=EUR',
            $response->authUrl()
        );
    }


    /** @test */
    public function get_the_payment_id()
    {
        $response = $this->mockResponseFrom('AuthorizeSuccess.txt');

        $this->assertEquals(
            'pay_1020007509_MSVdaKT5EVjVtmlmFAjYF3arsUazxz3n_EUR',
            $response->getPaymentId()
        );
    }


    /** @test */
    public function get_the_status()
    {
        $response = $this->mockResponseFrom('AuthorizeSuccess.txt');

        $this->assertEquals(
            'INITIATED',
            $response->getStatus()
        );
    }


    /** @test */
    public function get_the_resource_object_type()
    {
        $response = $this->mockResponseFrom('AuthorizeSuccess.txt');

        $this->assertEquals('PAYMENT', $response->getObject());
    }


    /** @test */
    public function get_the_message()
    {
        $response = $this->mockResponseFrom('AuthorizeFailure.txt');

        $this->assertEquals(
            '{"code":"invalid_api_key","message":"Authentication failed","number":10008}',
            $response->getMessage()
        );
    }


    /** @test */
    public function correct_http_response_status()
    {
        $successResponse = $this->mockResponseFrom('AuthorizeSuccess.txt');
        $failResponse = $this->mockResponseFrom('AuthorizeFailure.txt');

        $this->assertEquals(201, $successResponse->responseCode);
        $this->assertEquals(401, $failResponse->responseCode);
    }


    /**
     * Create a mock response from the given filename.
     *
     * @param $filename
     *
     * @return AuthorizeResponse
     */
    protected function mockResponseFrom($filename)
    {
        $httpResponse = $this->getMockHttpResponse($filename);

        return new AuthorizeResponse($this->getMockRequest(), $httpResponse->json(), $httpResponse->getStatusCode());
    }
}
