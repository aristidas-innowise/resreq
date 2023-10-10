# ResReq API Client

Client for the API of [ResReq](https://reqres.in/).

## Requirements

This package requires at least PHP 8.1

## Installation

```shell
composer require innowise/reqres
```

### Getting started

```php
// Initialize the API
$api = new \Innowise\ReqRes\ReqRes;

$response = $api->getUsers();

if ($response->ok()) {
    $response->json('data');
}
```

## Tests

Unit tests are stored in the `tests` folder. Run tests with:

```shell
composer test
```

