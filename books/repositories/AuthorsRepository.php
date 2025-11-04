<?php
declare(strict_types=1);

namespace books\repositories;

use books\models\Author;
use books\resources\AuthorResource;
use yii\web\NotFoundHttpException;

class AuthorsRepository
{
    public function getById(int $id): AuthorResource
    {
        $model = Author::findOne($id);
        if (!$model) throw new NotFoundHttpException('Не найдено');
        return AuthorResource::fromModel($model);
    }

    public function getTopAuthors(int $year): array
    {
        $authors =  Author::find()
            ->select(['authors.*', 'COUNT(books.id) AS books_count'])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit(10)
            ->all();

        return array_map(
            fn(Author $author) => AuthorResource::fromModel($author),
            $authors
        );
    }

}