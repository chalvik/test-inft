<?php

namespace books\services;

use books\repositories\BookRepository;
use books\services\SMS\SmsProvider;

class SubscribeSendService
{

    public function __construct(
        public SmsProvider $smsProvider,
        public BookRepository $bookRepository,
    )
    {}
    public function send():void
    {
        $newBooks = $this->bookRepository->getListNewForLastDay();

        foreach ($newBooks as $book) {
            foreach ($book->authors as $author) {
                foreach ($author->subscriptions as $sub) {
                    $phone = $sub->phone;
                    if ($phone) {
                        echo "Отправлено SMS на {$phone}: новая книга '{$book->title}' автора {$author->full_name}\n";
                        $this->smsProvider->send($phone);
                    }
                }
            }
        }

    }
}