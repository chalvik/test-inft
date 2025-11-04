<?php
declare(strict_types=1);

namespace books\repositories;

use books\models\Author;
use Yii;
use books\dto\Book\BookDto;
use books\models\Book;
use books\resources\BookResource;
use yii\web\NotFoundHttpException;

class BookRepository
{
    /**
     * @param int $id
     * @return BookResource
     * @throws NotFoundHttpException
     */
    public function getById(int $id): BookResource
    {
        $model = $this->getModelById($id);
        return BookResource::fromModel($model);
    }

    public function getList(): array
    {
        $books =  Book::find()
            ->with('authors')
            ->all();
        return array_map(fn($book) => BookResource::fromModel($book), $books);
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
        $result = true;
        try {
            $model = new Book();
            $model->title = $dto->title;
            $model->description = $dto->description;
            $model->isbn = $dto->isbn;
            $model->image = $dto->image;
            $model->save();

            if ($dto->authors) {
                foreach ($dto->authors as $authorId) {
                    $author = Author::findOne($authorId);
                    if ($author) {
                        $model->link('authors', $author);
                    }
                }
            }

        } catch (\Exception $exception) {
            $result =  false;
            Yii::error($exception->getMessage());
        }

        return $result;
    }

    /**
     * @param BookDto $dto
     * @return bool
     */
    public function update(int $id, BookDto $dto): bool
    {
        $result = true;
        try {
            $model = Book::findOne($id);
            $model->title = $dto->title;
            $model->description = $dto->description;
            $model->isbn = $dto->isbn;
            $model->image = $dto->image;
            $model->save();
        } catch (\Exception $exception) {
            $result = false;
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