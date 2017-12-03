<?php

namespace app\rbac;

use yii\rbac\Rule;
use app\models\Order;

/**
 * Rule для проверки принадлежности заказа пользователю.
 *
 */
 
class UserRule extends Rule
{
	public $name = 'isUser';
	public function execute($user, $item, $params)
	{
		return isset($params['order']) ? $params['order']->user_id == $user : false;
	}
}
