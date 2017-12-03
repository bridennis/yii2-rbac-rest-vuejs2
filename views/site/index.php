<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Orders');

$this->registerJsFile('/js/vue.min.js', [ 'position' => $this::POS_HEAD ]);
	$this->registerJsFile('/js/vee-validate/vee-validate.js', [ 'position' => $this::POS_HEAD ]);
		$this->registerJsFile('/js/vee-validate/locale/ru.js', [ 'position' => $this::POS_HEAD ]);
	$this->registerJsFile('/js/uiv.min.js', [ 'position' => $this::POS_HEAD ]);
$this->registerJsFile('/js/vue-app/app.js', [ 'depends' => [yii\web\JqueryAsset::className()] ]);

?>

<div class="order-index" id='app'>

	<h1><?= Html::encode($this->title) ?> [{{ orders.length }}]</h1>
	
	<div id="filter-bar">
		<template>
			Фильтр по дате размещения: с 
			<form class="form-inline">
				<dropdown class="form-group">
					<div class="input-group">
						<input class="form-control" type="text" name="date-start" v-model="dateStart" v-validate="'date_format:YYYY-MM-DD'" data-vv-as="Дата с">
						<div class="input-group-btn">
							<btn class="dropdown-toggle"><i class="glyphicon glyphicon-calendar"></i></btn>
						</div>
					</div>
					<template slot="dropdown">
						<li>
							<date-picker v-model="dateStart" :week-starts-with="1" />
						</li>
					</template>
				</dropdown>
			</form>
			по
			<form class="form-inline">
				<dropdown class="form-group">
					<div class="input-group">
						<input class="form-control" type="text" name="date-stop" v-model="dateStop" v-validate="'date_format:YYYY-MM-DD'" data-vv-as="Дата по">
						<div class="input-group-btn">
							<btn class="dropdown-toggle"><i class="glyphicon glyphicon-calendar"></i></btn>
						</div>
					</div>
					<template slot="dropdown">
						<li>
							<date-picker v-model="dateStop" :week-starts-with="1" />
						</li>
					</template>
				</dropdown>
			</form>
			<btn type="primary" disabled v-if="errors.any()"><?= Yii::t('app', 'Apply'); ?></btn>
			<btn type="primary" @click="applyFilter()" v-if="!errors.any()"><?= Yii::t('app', 'Apply'); ?></btn>			
		</template>
	</div>
	<alert v-if="errors.has('date-start')" type="warning">{{ errors.first('date-start') }}</alert>
	<alert v-if="errors.has('date-stop')" type="warning">{{ errors.first('date-stop') }}</alert>

	<div>
	
		<table class="table table-bordered">

				<thead>
				<tr>
						<th><?= Yii::t('app', 'ID'); ?></th>
						<th><?= Yii::t('app', 'Date'); ?></th>
						<th><?= Yii::t('app', 'Description'); ?></th>
						<th><?= Yii::t('app', 'Order cost'); ?></th>
						<th><?= Yii::t('app', 'User'); ?></th>
						<th><?= Yii::t('app', 'Action'); ?></th>
				</tr>
				</thead>

				<tbody v-for='order in orders' v-if="!order.isFiltered">
					<tr>
						<td>{{ order.id }}</td>
						<td>{{ order.order_date }}</td>
						<td>{{ order.descr }}</td>
						<td>{{ order.cost }}</td>
						<td>{{ order.username }}</td>
						<td>
							<button class="btn btn-default btn-sm" type="button" @click="editOrder(order.id)" title="<?= Yii::t('app', 'Edit'); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
              <button class="btn btn-default btn-sm" type="button" @click="deleteOrder(order.id)" title="<?= Yii::t('app', 'Delete'); ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>						
						</td>
					</tr>
				</tbody>
				
		</table>
		
		<p>
				<a class="btn btn-primary" href="/" @click.prevent="createOrderForm.show=true"><?= Yii::t('app', 'Create Order'); ?></a>
		</p>
		
		<template>
			<section>
				<modal v-model="createOrderForm.show" title="Создание заказа" :backdrop="false">
				
					<div class="control-group">
						<label class="control-label" for="descr">Описание заказа:</label>
						<div class="controls">
							<textarea v-model="createOrderForm.descr" name="descr" class="wide" rows="4" v-validate="'required|max:255'" data-vv-as="Описание заказа"></textarea>
								<alert v-if="errors.has('descr')" type="warning">{{ errors.first('descr') }}</alert>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="cost">Сумма заказа:</label>
						<div class="controls">
							<input v-model="createOrderForm.cost" type="text" name="cost" class="wide" value="0.0" v-validate="'required|decimal:20'" data-vv-as="Сумма заказа" />
								<alert v-if="errors.has('cost')" type="warning">{{ errors.first('cost') }}</alert>
						</div>
					</div>
						 
					<div slot="footer">
						<btn @click="createOrderForm.show=false">Отмена</btn>
						<btn type="primary" disabled v-if="errors.any()">Сохранить</btn>
						<btn type="primary" @click="createOrder()" v-if="!errors.any()">Сохранить</btn>
					</div>
					
				</modal>
			</section>
		</template>

		<template>
			<section>
				<modal v-model="editOrderForm.show" title="Редактирование заказа" :backdrop="false">
				
					<div class="control-group">
						<label class="control-label" for="descr">Описание заказа:</label>
						<div class="controls">
							<textarea v-model="editOrderForm.descr" name="descr" class="wide" rows="4" v-validate="'required|max:255'" data-vv-as="Описание заказа"></textarea>
								<alert v-if="errors.has('descr')" type="warning">{{ errors.first('descr') }}</alert>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="cost">Сумма заказа:</label>
						<div class="controls">
							<input v-model="editOrderForm.cost" type="text" name="cost" class="wide" value="0.0" v-validate="'required|decimal:20'" data-vv-as="Сумма заказа" />
								<alert v-if="errors.has('cost')" type="warning">{{ errors.first('cost') }}</alert>
						</div>
					</div>
						 
					<div slot="footer">
						<btn @click="editOrderForm.show=false">Отмена</btn>
						<btn type="primary" disabled v-if="errors.any()">Сохранить</btn>
						<btn type="primary" @click="updateOrder(editOrderForm.id)" v-if="!errors.any()">Сохранить</btn>
					</div>
					
				</modal>
			</section>
		</template>

				
	</div>
</div>
