<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px" />
    </a>
    <a href="https://vuejs.org/images/logo.png" target="_blank">
        <img src="https://vuejs.org/images/logo.png" height="100px" />
    </a>
    <h1 align="center">Yii 2 + VueJS</h1>
    <br>
</p>

- Back-end проекта создан на Yii 2 Basic Project Template
    - Аутентификация и авторизация RBAC на модулях <a href="https://github.com/dektrium/yii2-user" target="_blank">yii2-user</a> и <a href="https://github.com/dektrium/yii2-rbac" target="_blank">yii2-rbac</a>
- Front-end проекта на VueJS 2
    - UI использует плагин <a href="http://vee-validate.logaretm.com/" target="_blank">VeeValidate</a> и компоненты <a href="https://uiv.wxsm.space/" target="_blank">UIV</a>


ТРЕБОВАНИЯ
----------

Проект создавался на платформе Apache 2, MariaDB 5.5, PHP 7.1


КОНФИГУРИРОВАНИЕ
----------------

### Database

Отредактируйте файл `config/db.php` заменив в нем значения данными необходимыми для подключения к вашей БД, к примеру:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=k-gorod-test',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

- В файле `create_table.sql` находятся все необходимые запросы для инициализации БД (движок InnoDB)

РАЗРАБОТЧИК ОСОЗНАЁТ:
----------------
- Структура таблицы заказов упрощена до минимума и содержит базовый набор полей без связей
- В реализации задания не используется постраничный вывод данных (pagination)
- Фильтрация выводимых данных по дате размещения заказа реализована только в клиентском интерфейсе
- Авторизация с REST сервером нарушает его stateless требование, выполняя сессионную идентификацию пользователей отправляющих к нему запросы
