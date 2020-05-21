# MessageX SDK - Node

# THIS SDK IS A WIP AND SHOULD NOT BE DOWNLOADED YET

---


![MessageX Logo](https://raw.githubusercontent.com/messagex/node-messagex/master/img/messagex-logo.png "MessageX")

This SDK provides enables node applications with an easy to use interface to the MessageX API.

---

* [Installation](#installation)
* [Examples](#examples)
* [Testing](#testing)

---

## Installation

```sh
composer require messagex/php-messagex
```

---

## Examples

### Sending email

Instantiate the library

```php
use messagex\messagex;

...

$client = new \PhpApiClient\Client($apiKey, $apiSecret);
```

The following example shows how to send an email.

```
$payload = [
    "contactGroupId" => "70266b1a-3e07-4096-90ec-87c8015872ca",
    "unsubscribeGroupId" => "4501ccf5-0f4b-4d36-b329-a0029b68ea0a",
    "from" => [ 
        "address" => "no-reply@smsglobal.com",
        "name" => "MessageX"
    ],
    "to" => [
        [
            "address" => "john@example.com",
            "name" => "Test email message"
        ],
    ],
    "subject" => "Transactional Email 1",
    "content" => [
        [
            "type" => "text/html",
            "body" => "<body>This is the body. Go to <a href=\"http://theage.com.au?one=two\">The Age</a> to see the news. Or go to <a href=\"https://google.com\">Google</a> to search for more</body>"
        ],
        [
            "type" => "text/plain",
            "body" => "AAA Plaintext email content."
        ]
    ],
    "replyTo" => [
        "name" => "reply-to-me",
        "address" => "someone@example.com"
    ],
];

$client->mail()->send($payload);
```

## Testing

To run tests, run the script `tests/run-tests.sh`. Coverage reports are 
saved to the `./html` which you should view in your browser.