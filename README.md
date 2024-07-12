Задание
---
Реализовать простейшее CRUD веб приложение по работе с заказами.

В качестве бэкенд фреймворка используйте Yii2.

Работу с заказами оформите в виде SPA на базе фронтенд фреймворка VueJS 2.

Доступ к заказам разграничить по пользователям.

---

Реализация
---

<p style="text-align: center">
    <a href="https://www.yiiframework.com/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px" alt="Yii framework logo" />
    </a>
    <a href="https://vuejs.org/" target="_blank">
        <img src="https://vuejs.org/images/logo.png" height="100px" alt="Yii framework logo" />
    </a>
</p>
<h1 style="text-align: center">Yii2 + VueJS 2</h1>

- Back-end: [Yii2](https://www.yiiframework.com/)
    - Аутентификация ([yii2-user](https://github.com/dektrium/yii2-user)) и авторизация RBAC ([yii2-rbac](https://github.com/dektrium/yii2-rbac))
- Front-end: [VueJS 2](https://vuejs.org/)
    - UI использует плагин [VeeValidate](http://vee-validate.logaretm.com/) и компоненты [UIV](https://uiv.wxsm.space/)


Требования
---

Платформа: Nginx (Apache), MySQL 5.7, PHP 8.2.x


Установка (Deployment)
---

> Для развертывания необходим `docker-compose` [[ссылка]](https://docs.docker.com/compose/install/)


Запускаем из корневой папки проекта:

```sh
docker-compose up -d
```

Доступ
---

Веб интерфейс доступен по адресу: [http://localhost/](http://localhost/)

Разработчик осознаёт:
---

- Структура таблицы заказов упрощена до минимума и содержит базовый набор полей без связей
- В реализации задания не используется постраничный вывод данных (pagination)
- Фильтрация выводимых данных по дате размещения заказа реализована только в клиентском интерфейсе
- Авторизация с REST сервером нарушает его stateless требование, выполняя сессионную идентификацию пользователей отправляющих к нему запросы

ToDo
--

- [ ] Пагинация
- [ ] Фильтрация
- [ ] REST документация по спеке OAS 3 (Swagger)
- [ ] Тесты  
- [x] Уйти от типа decimal(20, 2) для суммы заказа к типу integer (храним всё в минимальной величине - копейках, избавляясь от будущих проблем с округлением) 
