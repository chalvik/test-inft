<?php
declare(strict_types=1);

namespace console\controllers;

use books\models\Book;
use yii\console\Controller;

class NotifyController extends Controller
{
    public function actionSubscribers()
    {
        $newBooks = Book::find()
            ->where(['>', 'created_at', date('Y-m-d H:i:s', strtotime('-1 day'))])
            ->with('authors.subscriptions')
            ->all();

        foreach ($newBooks as $book) {
            foreach ($book->authors as $author) {
                foreach ($author->subscriptions as $sub) {
                    $phone = $sub->phone;
                    if ($phone) {
                        echo "Отправлено SMS на {$phone}: новая книга '{$book->title}' автора {$author->full_name}\n";
                    }
                }
            }
        }
    }
}
