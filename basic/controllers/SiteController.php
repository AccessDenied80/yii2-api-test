<?php
declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
            $this->redirect(Url::to([Yii::$app->params['redirect_url_after_login']]));

        $this->redirect(Url::to(['/auth/login']));
    }

}
