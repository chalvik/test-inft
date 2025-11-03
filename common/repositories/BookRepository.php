<?php
declare(strict_types=1);

namespace common\repositories;

use common\components\book\BookDto;
use common\models\Book;
use Yii;
use yii\web\NotFoundHttpException;

class BookRepository
{
    public function getById(int $id): BookDto
    {

    }

    public function getList(): BookPaginateDto
    {

    }


    public function getListNewForLastDay(): array
    {

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
     * @param int $id
     * @return false|int
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(int $id): false|int
    {
        $model = Book::findOne($id);
        if (!$model) throw new NotFoundHttpException('Не найдено');
        return $model->delete();
    }
}