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

- Back-end: Yii 2
    - Аутентификация и авторизация RBAC на модулях <a href="https://github.com/dektrium/yii2-user" target="_blank">yii2-user</a> и <a href="https://github.com/dektrium/yii2-rbac" target="_blank">yii2-rbac</a>
- Front-end: VueJS 2
    - UI использует плагин <a href="http://vee-validate.logaretm.com/" target="_blank">VeeValidate</a> и компоненты <a href="https://uiv.wxsm.space/" target="_blank">UIV</a>


ТРЕБОВАНИЯ
----------

Платформа: Nginx, MySQL 5.7, PHP 7.1.x


УСТАНОВКА
---------

Устанавливаем (если необходимо) ```docker-composer``` [[ссылка]](https://docs.docker.com/compose/install/)

Запускаем из корневой папки проекта:

```
dc up -d

dc exec yii2 sh -c "composer install"

chmod a+x www/yii

dc exec yii2 sh -c "yes | ./yii migrate"

chmod a+w www/web/assets/ www/runtime/

```

ЗАПУСК
------

Веб интерфейс доступен по адресу: [http://localhost/](http://localhost/)

РАЗРАБОТЧИК ОСОЗНАЁТ:
----------------
- Структура таблицы заказов упрощена до минимума и содержит базовый набор полей без связей
- В реализации задания не используется постраничный вывод данных (pagination)
- Фильтрация выводимых данных по дате размещения заказа реализована только в клиентском интерфейсе
- Авторизация с REST сервером нарушает его stateless требование, выполняя сессионную идентификацию пользователей отправляющих к нему запросы
