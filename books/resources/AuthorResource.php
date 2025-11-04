<?php
declare(strict_types=1);

namespace books\resources;
use books\models\Author;

final class AuthorResource
{
    public function __construct(
        public int $id,
        public string $firstName,
        public ?string $surname,
        public string $patronymic,
    ) {}

    static function fromModel(Author $model): self
    {
        return new self(
            id: $model->id,
            firstName: $model->firstname,
            surname: $model->surname,
            patronymic: $model->patronymic,
        );
    }
}