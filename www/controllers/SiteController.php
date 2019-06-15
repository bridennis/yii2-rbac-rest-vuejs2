<?php

namespace app\controllers;

use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                        'class' => AccessRule::className(),
                ],
                'rules' => [
                        [
                                'actions' => ['login'],
                                'allow' => true,
                                'roles' => ['?'],
                        ],
                        [
                                'actions' => ['error'],
                                'allow' => true,
                                'roles' => ['?', '@'],
                        ],
                        [
                                'actions' => ['index', 'logout'],
                                'allow' => true,
                                'roles' => ['@'],
                        ],
                ],
        ];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}
