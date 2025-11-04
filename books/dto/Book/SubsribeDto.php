<?php
declare(strict_types=1);

namespace books\dto\Book;
class SubsriptionDto
{
    public function __construct(
        public string $phone,
        public ?int $user_id
){}
    static function fromArray(array $data): self
    {
        return new self(
            phone: $data['phone'],
            user_id: $data['user_id']
        );
    }
}