<?php
declare(strict_types=1);

namespace frontend\controllers;

use books\dto\Book\BookDto;
use books\forms\FormBook;
use books\repositories\BookRepository;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

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
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return $this->render('index', ['books' => $this->repository->getList()]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        return $this->render('view', ['book' => $this->repository->getById($id)]);
    }

    public function actionStore()
    {
        $formModel = new FormBook();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $this->repository->store(BookDto::fromArray(Yii::$app->request->post()));
        }
        return $this->goBack();
    }

    public function actionUpdate(int $id)
    {
        $formModel = new FormBook();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $this->repository->update($id, BookDto::fromArray(Yii::$app->request->post()));
        }
        return $this->goBack();
    }

    public function actionDelete(int $id)
    {
        $this->repository->delete($id);
        return $this->goBack();
    }
}
