<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $order_date
 * @property string $descr
 * @property string $cost
 * @property integer $user_id
 *
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descr', 'cost'], 'required'],
            [['order_date'], 'safe'],
						[['order_date'], 'default', 'value' => date('Y-m-d')],
						[['order_date'], 'date', 'format' => 'Y-m-d'],
            [['user_id'], 'integer'],
						[['user_id'], 'default', 'value' => Yii::$app->user->id],
            [['cost'], 'number'],
            [['descr'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_date' => Yii::t('app', 'Date'),
            'descr' => Yii::t('app', 'Description'),
            'cost' => Yii::t('app', 'Order cost'),
            'user_id' => Yii::t('app', 'User'),
        ];
    }
		
		public function fields()
		{
				$fields = parent::fields();
				$fields['username'] = function () {
						return $this->user->username ? $this->user->username : null;
				};
				return $fields;
		}
		
    public function getUser()
    {
        // an Order has one User
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }		

}
