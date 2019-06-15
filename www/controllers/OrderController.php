<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\Order;

/**
 * REST контроллер заказов
 *
 * Доступ к контроллеру только для аутентифицированных пользователей
 *
 * GET /orders - список всех заказов пользователя (администратор видит все заказы)
 * GET /orders/1 - просмотр заказа с ID = 1, если он был создан текущим пользователем (администратор видит все заказы)
 * POST /orders - добавление заказа
 * PUT /orders/1 - обновление заказа с ID = 1, если он был создан текущим пользователем (либо это администратор)
 * DELETE /orders/1 - удаление заказа с ID = 1, если он был создан текущим пользователем (либо это администратор)
 *
 */

class OrderController extends ActiveController
{
    public $modelClass = 'app\models\Order';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'matchCallback' =>
                        function () {
                            return Yii::$app->user->can('orderRead', ['order' =>
                                $this->findModel(Yii::$app->request->get('id'))]);
                        },
                ],
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'matchCallback' =>
                        function () {
                            return Yii::$app->user->can('orderUpdate', ['order' =>
                                $this->findModel(Yii::$app->request->get('id'))]);
                        },
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'matchCallback' =>
                        function () {
                            return Yii::$app->user->can('orderDelete', ['order' =>
                                $this->findModel(Yii::$app->request->get('id'))]);
                        },
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * Переопределяем actions по своему осмотрению
     */
    public function actions()
    {

        $actions = parent::actions();

        // index (каждому пользователю показываем свое, если только он не админ)

        $actions['index']['prepareDataProvider'] =  function () {
            return new ActiveDataProvider([
                'query' => (Yii::$app->user->can('admin') ? Order::find()->with('user') :
                    Order::find()->with('user')->where(['user_id' => Yii::$app->user->id])),
            ]);
        };

        return $actions;
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
