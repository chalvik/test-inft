<?php
declare(strict_types=1);

namespace common\resources;
class BookResource
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public ?AuthorResource $author = null,
        public int $year,
        public ?string $isbn = null,
        public ?string $image = null,
    ) {}
}