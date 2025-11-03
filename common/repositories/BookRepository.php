<?php
declare(strict_types=1);

namespace common\repositories;

use common\components\book\BookDto;
use common\models\Book;
use common\resources\AuthorResource;
use common\resources\BookResource;
use Yii;
use yii\web\NotFoundHttpException;

class BookRepository
{
    public function getById(int $id): BookResource
    {
        $model = $this->getModelById($id);

        $author = new AuthorResource(
            id: $model->author->id,
            firstName: $model->author->firstname,
            lastName: $model->author->lastname,
            patronymic: $model->author->firstname
        );
        return new BookResource(
            id: $model->id,
            title: $model->title,
            description: $model->description,
            author: $author,
            year: $model->year,
            isbn: $model->isbn,
            image: $model->image,
        );
    }

    public function getList(): array
    {
        $books =  Book::find()
            ->asArray()
            ->all();

        return array_map(fn($book) => new BookResource(
            id: $book['id'],
            title: $book['title'],
            description: $book['description'],
            year: $book['year'],
            isbn: $book['isbn'],
            image: $book['image'],
        ),
            $books
        );
    }

    public function getListNewForLastDay(): array
    {
        return [];
    }

    /**
     * @param BookDto $dto
     * @return bool
     */
    public function store(BookDto $dto): bool
    {
        $result = false;
        try {
            $model = new Book();
            $model->title = $dto->title;
            $model->description = $dto->description;
            $model->isbn = $dto->isbn;
            $model->image = $dto->image;
            $result =  $model->save();
        } catch (\Exception $exception) {
            Yii::error($exception->getMessage());;
        }

        return $result;
    }

    /**
     * @param BookDto $dto
     * @return bool
     */
    public function update(int $id, BookDto $dto): bool
    {
        $result = false;
        try {
            $model = Book::findOne($id);
            $model->title = $dto->title;
            $model->description = $dto->description;
            $model->isbn = $dto->isbn;
            $model->image = $dto->image;
            $result =  $model->save();
        } catch (\Exception $exception) {
            Yii::error($exception->getMessage());;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return false|int
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(int $id): false|int
    {
        $model = $this->getModelById($id);
        return $model->delete();
    }

    private function getModelById(int $id): Book
    {
        $model = Book::findOne($id);
        if (!$model) throw new NotFoundHttpException('Не найдено');
        return $model;
    }
}