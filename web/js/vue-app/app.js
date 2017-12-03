Vue.use(VeeValidate, {
  locale: 'ru',
});

var vm = new Vue({
	el: '#app',
  data: {
		orders: [],
		createOrderForm: {
			show: false,			// Признак активности модального окна "Создание заказа"
			descr: 'заказ',
			cost: '0.0',
		},
		editOrderForm: {
			show: false,			// Признак активности модального окна "Редактирование заказа"
			id: -1,
			descr: '',
			cost: '',
		},
		dateStart: '',			// Начальная дата фильтра
		dateStop: '',				// Конечная дата фильтра
  },
	
	mounted() {
		this.reloadOrder();
	},
	
  methods: {
		
	// Фильтр по дате размещения
	
		applyFilter: function () {
			
			// Меняем даты местами, если это необходимо
			
			if ((this.dateStop != '' && this.dateStart != '') && this.dateStop < this.dateStart) {
				var tmp = this.dateStart;
				this.dateStart = this.dateStop;
				this.dateStop = tmp;
			}
			
			var self = this;
			
			this.orders.forEach(function(item, i) {
				if (self.dateStart == '' && self.dateStop == '') {
					self.orders[i].isFiltered = false;
					
				} else if (self.dateStart == '' || self.dateStop == '') {
					
					if (self.dateStart == '' && self.dateStop != '' && item.order_date > self.dateStop) {
						self.orders[i].isFiltered = true;
					} else if (self.dateStart != '' && self.dateStop == '' && item.order_date < self.dateStart) {
						self.orders[i].isFiltered = true;
					} else {
						self.orders[i].isFiltered = false;
					}
				
				} else if (item.order_date < self.dateStart || item.order_date > self.dateStop) {
					self.orders[i].isFiltered = true;
				} else {
					self.orders[i].isFiltered = false;
				}
			});
		},
		
	// Вывод списка заказов
		
		reloadOrder: function () {
			var self = this;
			$.ajax({
				dataType: 'json',
				url: '/orders',
			})
			.done( function (data) {
				data.forEach(function(item, i) {
					data[i].isFiltered = false;
				});
				self.orders = data;
				self.applyFilter();
			})
			.fail( function (data) {
				console.log(data);
			});
		},
		
		
	// Создание заказа
		
    createOrder: function () {
			
			var self = this;
				
			$.ajax({
				method: 'POST',
				url: '/orders',
				data: { descr: this.createOrderForm.descr, cost: this.createOrderForm.cost }				
			})
			.done( function (data) {
				
				self.createOrderForm.show = false;
				self.reloadOrder();
				self.notifySuccess('Создание завершено!');
				
			})
			.fail( function (data) {
				self.notifyWarning('Ошибка создания');
			});
			
    },	
		
	// Обновление заказа
		
    updateOrder: function (id) {
			
			var self = this;
				
			$.ajax({
				method: 'PUT',
				url: '/orders/' + id,
				data: { descr: this.editOrderForm.descr, cost: this.editOrderForm.cost }				
			})
			.done( function (data) {
				
				self.editOrderForm.show = false;
				self.reloadOrder();
				self.notifySuccess('Обновление завершено!');
				
			})
			.fail( function (data) {
				self.notifyWarning('Ошибка обновления');
			});
    },
		
	// Редактирование заказа
		
    editOrder: function (id) {
			
			var self = this;
			
			// На UI не ориентируемся, берем из базы свежие данные, если их нет - сообщаем об этом
			
				$.ajax({
					url: '/orders/' + id,
				})
				.done( function (data) {
					
					self.editOrderForm.descr = data.descr;
					self.editOrderForm.cost = data.cost;
					self.editOrderForm.id = data.id;
					self.editOrderForm.show = true;
					
				})
				.fail( function (data) {
					self.notifyWarning('Ошибка чтения заказа');
				});
				
			
    },
		
	// Удаление заказа
		
    deleteOrder: function (id) {
			
			var self = this;
				
			this.$confirm({
				content: 'Удалить заказ № [' + id + ']?'
			})
			.then(() => {
				
				$.ajax({
					method: 'DELETE',
					url: '/orders/' + id,
				})
				.done( function (data) {
					
					self.reloadOrder();
					self.notifySuccess('Удаление завершено!');

				})
				.fail( function (data) {
					self.notifyWarning('Ошибка удаления');					
				});
				
      });
					
    },
		
	// Нотификаторы
	
		notifySuccess: function (content) {
			this.notify('success', content);
		},
		notifyWarning: function (content) {
			this.notify('warning', content);
		},
		notify: function (type, content) {
			this.$notify({ type: type, content: content, placement: 'bottom-right', duration: 3000 });
		},
		
  }	
})
