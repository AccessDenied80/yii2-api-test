<?php
declare(strict_types=1);

namespace app\controllers;

use Yii;

use yii\helpers\Url;
use yii\grid\GridView;
use app\models\ApiData;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class CabinetController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
            $this->redirect(Url::to(['/auth/login']));

        $dataProvider = new ActiveDataProvider([
            'query' => ApiData::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $data = GridView::widget([
            'dataProvider' => $dataProvider,
        ]);

        return $this->render('@app/views/site/cabinet/index', [
            'data' => $data
        ]);

    }
}