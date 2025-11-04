<?php
declare(strict_types=1);

namespace frontend\controllers;

use books\repositories\AuthorsRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

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
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function actionTopAuthors($year)
    {
        return $this->view(
            'authors.top-authors', [
            'authors' => $this->repository->getTopAuthors($year),
        ]);
    }
}
