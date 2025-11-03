<?php
declare(strict_types=1);

namespace common\resources;
class BookPagesResource
{
    private array $books;
    public function __construct(
        public array $page,
    ) {}

    public function push(BookResource $resource): void
    {
        $this->books[] = $resource;
    }

    public function get(): array
    {
        return [
            'data' => $this->books,
            'pagination' => [
                'total' => $this->total,
                'page' => $this->page,
            ],
        ];
    }
}