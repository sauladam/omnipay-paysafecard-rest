<?php

namespace Omnipay\Paysafecard\Message;

class AuthorizeResponse extends Response
{
    /**
     * Get the auth URL.
     *
     * @return string
     */
    public function authUrl()
    {
        return $this->data['redirect']['auth_url'];
    }
}
