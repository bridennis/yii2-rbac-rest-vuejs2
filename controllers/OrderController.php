<?php

namespace app\controllers;

use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\rest\ActiveController;
use app\models\Order;
use yii\data\ActiveDataProvider;

/**
 * REST ���������� �������
 *
 *	������ � ����������� ������ ��� ������������������� �������������
 *
 *	GET /orders - ������ ���� �������, ���� ������� ������������ �������������, ��� ������ ��� �������, ������� ������� ������� �������������
 *	GET /orders/1 - �������� ������ � ID = 1, ���� �� ��� ������ ������� ������������� ��� ���� ������� ������������ �������������
 *	POST /orders - ���������� ������
 *	PUT /orders/1 - ���������� ������ � ID = 1, ���� �� ��� ������ ������� ������������� ��� ���� ������� ������������ �������������
 *	DELETE /orders/1 - �������� ������ � ID = 1, ���� �� ��� ������ ������� ������������� ��� ���� ������� ������������ �������������
 *
 */

class OrderController extends ActiveController
{
	public $modelClass = 'app\models\Order';
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['access'] = [
			'class' => AccessControl::className(),
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
					'matchCallback' => function ($rule, $action) {
							return \Yii::$app->user->can('orderRead', ['order' => $this->findModel(\Yii::$app->request->get('id'))]);
					},
				],
				[
					'actions' => ['update'],
					'allow' => true,
					'matchCallback' => function ($rule, $action) {
							return \Yii::$app->user->can('orderUpdate', ['order' => $this->findModel(\Yii::$app->request->get('id'))]);
					},
				],
				[
					'actions' => ['delete'],
					'allow' => true,
					'matchCallback' => function ($rule, $action) {
							return \Yii::$app->user->can('orderDelete', ['order' => $this->findModel(\Yii::$app->request->get('id'))]);
					},
				],
			],
		];
		return $behaviors;
  }
	
	/**
	 * �������������� actions �� ������ ����������
	 */
	public function actions()
  {
		
		$actions = parent::actions();
		
		// index (������� ������������ ���������� ����, ���� ������ �� �� �����)
		
		$actions['index']['prepareDataProvider'] =  function ($action) {
			return new ActiveDataProvider([
				'query' => (\Yii::$app->user->can('admin') ? Order::find()->with('user') : Order::find()->with('user')->where(['user_id' => \Yii::$app->user->id])),
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
