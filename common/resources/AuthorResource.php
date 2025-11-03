<?php
declare(strict_types=1);

namespace common\resources;
final class AuthorResource
{
    public function __construct(
        public int $id,
        public string $firstName,
        public ?string $lastName,
        public string $patronymic,
    ) {}
}