<?php
declare(strict_types=1);

namespace common\components\book;
class BookDto
{
    public function __construct(
      public ?string $title,
      public ?string $description,
      public ?int $isbn,
      public ?int $year,
      public ?string $image = null,
    ){}
}