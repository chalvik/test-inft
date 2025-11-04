<?php
declare(strict_types=1);

namespace books\dto\Book;
class BookDto
{
    public function __construct(
      public ?string $title,
      public ?string $description,
      public ?array $authors,
      public ?int $isbn,
      public ?int $year,
      public ?string $image = null,
    ){}

    static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            isbn: $data['isbn'],
            year: $data['year'],
            image: $data['image'],
        );
    }
}