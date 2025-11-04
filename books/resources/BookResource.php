<?php
declare(strict_types=1);

namespace books\resources;

use books\models\Book;

class BookResource
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public ?array $authors = [],
        public int $year,
        public ?string $isbn = null,
        public ?string $image = null,
    ) {}

    static function fromModel(Book $model): self
    {
        $authors = [];
        foreach ($model->getAuthors() as $author) {
            $authors[] = AuthorResource::fromModel($author);
        }

        return new self(
            id: $model->id,
            title: $model->title,
            description: $model->description,
            authors: $authors,
            year: $model->year,
            isbn: $model->isbn,
            image: $model->image,
        );
    }
}