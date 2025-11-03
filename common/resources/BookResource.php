<?php
declare(strict_types=1);

namespace common\resources;
class BookResource
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public string $author,
        public string $year,
        public ?string $isbn,
        public ?string $image,
    ) {}
}