<?php

namespace app\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Order[] $orders
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
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        // a User has many orders
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }
}
