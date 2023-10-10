<?php

namespace Innowise\ReqRes;

use Exception;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Innowise\ReqRes\DTO\UserDTO;
use Illuminate\Support\Collection;
use Innowise\ReqRes\DTO\Meta;

class ReqRes extends Factory
{

    protected const API_VERSION = "/api";
    protected const BASE_URL = 'https://reqres.in';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsers(int $perPage, int $page): Paginator
    {
        $response = $this->get('/users', [
            'per_page' => $perPage,
            'page' => $page
        ]);
        // todo: refactor it into separate SendRequestMethod with validation
        if ($response->getStatusCode() !== 200) {
            throw new Exception("Error Processing getUsers Request", $response->getStatusCode());
        }
        $data = json_decode($response, true);
        $response = collect($data['data'])->map(function ($user) {
            return UserDTO::fromArray($user);
        });
        $meta = Meta::fromResponse($data);

        return new Paginator($response, $meta);
    }

    public function getUser(int $id): UserDTO
    {
        $response = $this->get('/users/' . $id);
        // todo: refactor it into separate SendRequestMethod with validation
        if ($response->getStatusCode() !== 200) {
            throw new Exception("Error Processing getUsers Request", $response->getStatusCode());
        }
        $body = $response->getBody();
        $data = json_decode($body, true);

        return UserDTO::fromArray($data['data']);
    }

    public function createUser(string $name, string $job): int
    {
        $response = $this->post('/users', ['name' => $name, 'job' => $job]);
        // todo: refactor it into separate SendRequestMethod with validation
        if ($response->getStatusCode() !== 201) {
            throw new Exception("Error Processing getUsers Request", $response->getStatusCode());
        }
        $response = json_decode($response, true);

        return (int) $response['id'];
    }

    protected function newPendingRequest(): PendingRequest
    {
        return parent::newPendingRequest()
            ->baseUrl(self::BASE_URL . self::API_VERSION)
            ->acceptJson()
            ->asJson();
    }
}