<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Book;
use app\models\Author;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['actions' => ['index', 'view', 'top-authors'], 'allow' => true],
                    ['actions' => ['create', 'update', 'delete'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->asJson(Book::find()->with('authors')->all());
    }

    public function actionView($id)
    {
        $book = Book::find()->where(['id' => $id])->with('authors')->one();
        if (!$book) throw new NotFoundHttpException('Книга не найдена.');
        return $this->asJson($book);
    }

    public function actionCreate()
    {
        $model = new Book();
        $data = Yii::$app->request->post();
        $model->load($data, '');
        if ($model->save()) {
            if (!empty($data['author_ids'])) {
                foreach ($data['author_ids'] as $authorId) {
                    Yii::$app->db->createCommand()
                        ->insert('book_author', ['book_id' => $model->id, 'author_id' => $authorId])
                        ->execute();
                }
            }
            return $this->asJson(['status' => 'ok', 'book_id' => $model->id]);
        }
        return $this->asJson($model->errors);
    }

    public function actionUpdate($id)
    {
        $model = Book::findOne($id);
        if (!$model) throw new NotFoundHttpException('Не найдено');

        $model->load(Yii::$app->request->post(), '');
        if ($model->save()) return $this->asJson(['status' => 'updated']);
        return $this->asJson($model->errors);
    }

    public function actionDelete($id)
    {
        $model = Book::findOne($id);
        if (!$model) throw new NotFoundHttpException('Не найдено');
        $model->delete();
        return $this->asJson(['status' => 'deleted']);
    }

    public function actionTopAuthors($year)
    {
        $top = Author::find()
            ->select(['authors.id', 'authors.full_name', 'COUNT(books.id) AS books_count'])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->asJson($top);
    }
}
