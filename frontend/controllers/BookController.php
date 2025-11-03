<?php

namespace frontend\controllers;

use common\components\book\BookDto;
use common\repositories\BookRepository;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

final class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['actions' => ['index', 'view'], 'allow' => true],
                    ['actions' => ['create', 'update', 'delete'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        $config = [],
        public BookRepository $repository
    )
    {
        return parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return $this->render('index', ['books' => $this->repository->getList()]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['book' => $this->repository->getById($id)]);
    }

    public function actionStore()
    {
        $result = $this->repository->store(new BookDto(
            title: Yii::$app->request->post('title'),
            description: Yii::$app->request->post('description'),
            isbn: Yii::$app->request->post('isbn'),
            year: Yii::$app->request->post('year'),
        ));

        return $this->goBack();
    }

    public function actionUpdate($id)
    {
        $result = $this->repository->update($id, new BookDto(
            title: Yii::$app->request->post('title'),
            description: Yii::$app->request->post('description'),
            isbn: Yii::$app->request->post('isbn'),
            year: Yii::$app->request->post('year'),
        ));
        return $this->goBack();
    }

    public function actionDelete($id)
    {
        $this->repository->delete($id);
        return $this->goBack();
    }
}
