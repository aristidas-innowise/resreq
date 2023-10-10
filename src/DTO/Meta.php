<?php

namespace Innowise\ReqRes\DTO;

class Meta
{
    public function __construct(
        public int $page,
        public int $perPage,
        public int $total,
        public int $totalPages,
    ) {
    }

    public static function fromResponse(array $data): self
    {
        return new self(
            (int) ($data['page'] ?? 1),
            (int) ($data['per_page'] ?? 10),
            (int) ($data['total'] ?? 0),
            (int) ($data['total_pages'] ?? 0),
        );
    }
}