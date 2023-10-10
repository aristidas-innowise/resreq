<?php

namespace Innowise\ReqRes\DTO;

use GuzzleHttp\Client;
use JsonSerializable;

class UserDTO implements JsonSerializable
{
    public function __construct(
        public ?int $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $avatar,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['email'] ?? "",
            $data['first_name'] ?? "",
            $data['last_name'] ?? "",
            $data['avatar'] ?? "",
        );
    }

    // Implement the JsonSerializable interface
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'avatar' => $this->avatar,
        ];
    }
}