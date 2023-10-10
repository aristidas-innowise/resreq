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
$newUser = ReqRes::createUser("Supername", "programmer"); //name, job
$user = ReqRes::getUser(40); // id
$users = ReqRes::getUsers(5, 1); //perPage, page
```

## Tests

Unit tests are stored in the `tests` folder. Run tests with:

```shell
composer test
```

## How to use in Laravel?
Please add those parameters to your composer.json file and run `composer update`

```json
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/aristidas-innowise/resreq.git"
        }
    ],
```

```json
"require": {
        "innowise/reqres": "dev-main"
    },
```
