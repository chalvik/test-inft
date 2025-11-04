<?php
declare(strict_types=1);

namespace console\controllers;

use books\services\SubscribeSendService;
use yii\console\Controller;

class NotifyController extends Controller
{
    public function __construct(
        $id,
        $module,
        $config = [],
        public SubscribeSendService $subscribeSendService
    ){
        parent::__construct($id, $module, $config);
    }

    public function actionSubscribers()
    {
        $this->subscribeSendService->send();
    }
}
