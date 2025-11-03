<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Book;
use app\models\Author;
use yii\web\NotFoundHttpException;

final class AuthorsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['actions' => ['top-authors'], 'allow' => true],
                ],
            ],
        ];
    }

    public function __construct(
        $id,
        $module,
        $config = [],
        public AuthorRepository $repository
    ){}

    public function actionTopAuthors($year)
    {
        return $this->view(
            'authors.top-authors', [
                'authors' => $this->repository->getTopAuthors($year),
        ]);
    }
}
