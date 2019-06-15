<?php

namespace app\models;

use yii\db\ActiveQuery;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property Order[] $orders
 * @property string $username
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return ActiveQuery
     */
    public function getOrders()
    {
        // a User has many orders
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }
}
