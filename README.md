# Omnipay: Paysafecard (REST API)

**Paysafecard driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/sauladam/omnipay-paysafecard-rest.svg?branch=master)](https://travis-ci.org/sauladam/omnipay-paysafecard-rest)
[![Total Downloads](https://poser.pugx.org/sauladam/omnipay-paysafecard-rest/downloads.png)](https://packagist.org/packages/sauladam/omnipay-paysafecard-rest)

This is non-official Omnipay-driver for the payment gateway provider [Paysafecard](https://www.paysafecard.com).
In order to use it the Omnipay-Framework is required.

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Paysafecard REST API support for Omnipay.

## Installation

This package is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```bash
    $ composer require sauladam/omnipay-paysafecard-rest
```

And run composer to update your dependencies:

    $ composer update


## Basic Usage

The following gateway is provided by this package:

* Paysafecard_Rest

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

### Setting up the gateway
This is quite simple because the API only needs an API key.

```php
require 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('Paysafecard_Rest');

$gateway->setApiKey('yourApiKey');

// Testmode is on by default, so you want to switch it off for production.
$gateway->setTestMode(false); // default: true

```

### Initializing / authorizing a payment

```php
$response = $gateway->authorize([
    'amount' => 0.01,
    'currency' => 'EUR',
    'success_url' => 'http://success.com/{payment_id}',
    'failure_url' => 'http://fail.com/{payment_id}',
    'notification_url' => 'http://notify.com/{payment_id}',
    'customerId' => 1234,
])->send();

if ($response->isSuccessful()) {
    $paymentId = $response->getPaymentId(); 
    
    // this is the url you should redirect the customer 
    // to or display within an iframe
    $authUrl = $response->authUrl();
} else {
    echo 'Something went wrong: ' . $response->getMessage();
}
```
The auth URL points to a (secure) page where the customer can enter their Paysafecard PIN number. You can redirect the customer to that URL or embed it as an iframe and display it to them - either is fine.

After the customer has filled out and submitted the form, Paysafecard will redirect them to what you've specified as your *success_url* in the authorize request. Ideally that URL should contain some kind of payment identifier or some reference to your previously stored `$paymentId` (Paysafecard will replace the placeholder *{payment_id}* in the URL with the actual payment id), because you now need it to check the status of this transaction:

### Check the status
```php
$response = $gateway->details([
    'payment_id' => $paymentId,
])->send();
```
The status now should be *AUTHORIZED*, so check for that:
```php
if($response->getStatus() == 'AUTHORIZED')
{
    // The customer has authorized the payment, we're now ready to capture it.
}
```

### Capture the transaction

```php
$response = $gateway->capture([
    'payment_id' => $paymentId,
])->send();

if($response->getStatus() == 'SUCCESS') {
    // You have successfully captured the payment, the order is ready to ship.
}
```

## Support

For more usage examples please have a look at the tests of this package. Also have a look at the [Paysafecard API Documentation](https://www.paysafecard.com/fileadmin/api/) for further details.

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/sauladam/omnipay-paysafecard-rest/issues),
or better yet, fork the library and submit a pull request.
