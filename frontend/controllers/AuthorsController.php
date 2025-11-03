<?php
declare(strict_types=1);

namespace frontend\controllers;

use common\repositories\AuthorsRepository;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

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
        public AuthorsRepository $repository
    ){}

    public function actionTopAuthors($year)
    {
        return $this->view(
            'authors.top-authors', [
                'authors' => $this->repository->getTopAuthors($year),
        ]);
    }
}
