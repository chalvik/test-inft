<?php
declare(strict_types=1);

namespace common\repositories;

use common\models\Author;
use common\resources\AuthorResource;
use yii\web\NotFoundHttpException;

class AuthorsRepository
{
    public function getById(int $id): AuthorResource
    {
        $model = Author::findOne($id);
        if (!$model) throw new NotFoundHttpException('Не найдено');

        return new AuthorResource(
            id: $model->id,
            firstName: $model->firstname,
            lastName: $model->lastname,
            patronymic: $model->patronymic,
        );
    }

    public function getListNewForLastDay(int $year): array
    {
        $authors =  Author::find()
            ->select(['authors.*', 'COUNT(books.id) AS books_count'])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return array_map(fn($author) => new AuthorResource(
                id: $author['id'],
                firstName: $author['firstname'],
                lastName: $author['lastname'],
                patronymic: $author['patronymic'],
            ),
            $authors
        );
    }

}