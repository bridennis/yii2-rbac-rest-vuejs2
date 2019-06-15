<?php

use app\migrations\BaseMigration;

/**
 * Class m190602_141805_init_rbac
 */
class m190602_141805_init_rbac extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'auth_assignment',
            [
                'item_name' => $this->string(64)->notNull()->append('COLLATE utf8_unicode_ci'),
                'user_id' => $this->string(64)->notNull()->append('COLLATE utf8_unicode_ci'),
                'created_at' => $this->integer(11),
                'PRIMARY KEY(`item_name`,`user_id`)',
            ]
        );
        $this->batchInsert(
            'auth_assignment',
            [
                'item_name', 'user_id', 'created_at'
            ],
            [
                ['admin', '1', 1512134274],
                ['user', '2', 1512147850],
            ]
        );

        $this->createTable(
            'auth_item',
            [
                'name' => $this->string(64)->notNull()->append('COLLATE utf8_unicode_ci'),
                'type' => $this->smallInteger(6)->notNull()->append('COLLATE utf8_unicode_ci'),
                'description' => $this->text()->append('COLLATE utf8_unicode_ci'),
                'rule_name' => $this->string(64)->null()->append('COLLATE utf8_unicode_ci'),
                'data' => $this->binary(),
                'created_at' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'PRIMARY KEY(`name`)',
            ]
        );
        $this->batchInsert(
            'auth_item',
            [
                'name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at',
            ],
            [
                ['admin', 1, 'Администратор', null, null, 1512134238, 1512230922],
                ['orderCreate', 2, 'Создание заказа', null, null, 1512223579, 1512223579],
                ['orderDelete', 2, 'Удаление заказа', null, null, 1512223659, 1512223659],
                ['orderRead', 2, 'Просмотр заказа', null, null, 1512223609, 1512223609],
                ['orderReadUpdateDeleteOwn', 2, 'Чтение, обновление и удаление только собственного заказа',
                    'UserRule', null, 1512227245, 1512229219],
                ['orderUpdate', 2, 'Редактирование заказа', null, null, 1512223639, 1512223639],
                ['user', 1, 'Пользователь', null, null, 1512134253, 1512229124],
            ]
        );

        $this->createTable(
            'auth_item_child',
            [
                'parent' => $this->string(64)->notNull()->append('COLLATE utf8_unicode_ci'),
                'child' => $this->string(64)->notNull()->append('COLLATE utf8_unicode_ci'),
                'PRIMARY KEY(`parent`,`child`)',
            ]
        );
        $this->batchInsert(
            'auth_item_child',
            [
                'parent', 'child',
            ],
            [
                ['admin', 'orderDelete'],
                ['admin', 'orderRead'],
                ['admin', 'orderUpdate'],
                ['admin', 'user'],
                ['orderReadUpdateDeleteOwn', 'orderDelete'],
                ['orderReadUpdateDeleteOwn', 'orderRead'],
                ['orderReadUpdateDeleteOwn', 'orderUpdate'],
                ['user', 'orderReadUpdateDeleteOwn'],
            ]
        );

        $this->createTable(
            'auth_rule',
            [
                'name' => $this->string(64)->notNull()->append('COLLATE utf8_unicode_ci'),
                'data' => $this->binary(),
                'created_at' => $this->integer(11)->null(),
                'updated_at' => $this->integer(11)->null(),
                'PRIMARY KEY(`name`)',
            ]
        );
        $this->batchInsert(
            'auth_rule',
            [
                'name', 'data', 'created_at', 'updated_at',
            ],
            [
                [
                    'UserRule',
                    'O:17:"app\rbac\UserRule":3:{s:4:"name";s:8:"UserRule";s:9:"createdAt";i:1512227096;s:9:"updatedAt";i:1512227096;}',
                    1512227096,
                    1512227096
                ],

            ]
        );

        $this->createTable(
            'profile',
            [
                'user_id' => $this->integer(11)->notNull(),
                'name' => $this->string(255)->null()->append('COLLATE utf8_unicode_ci'),
                'public_email' => $this->string(255)->null()->append('COLLATE utf8_unicode_ci'),
                'gravatar_email' => $this->string(255)->null()->append('COLLATE utf8_unicode_ci'),
                'gravatar_id' => $this->string(32)->null()->append('COLLATE utf8_unicode_ci'),
                'location' => $this->string(255)->null()->append('COLLATE utf8_unicode_ci'),
                'website' => $this->string(255)->null()->append('COLLATE utf8_unicode_ci'),
                'bio' => $this->text()->append('COLLATE utf8_unicode_ci'),
                'timezone' => $this->string(40)->null()->append('COLLATE utf8_unicode_ci'),
                'PRIMARY KEY(`user_id`)',
            ]
        );
        $this->batchInsert(
            'profile',
            [
                'user_id', 'name', 'public_email', 'gravatar_email', 'gravatar_id', 'location', 'website',
                'bio', 'timezone',
            ],
            [
                [1, null, null, null, null, null, null, null, null],
                [2, null, null, null, null, null, null, null, null],
            ]
        );

        $this->createTable(
            'social_account',
            [
                'id' => $this->integer(11)->notNull(),
                'user_id' => $this->integer(11)->null(),
                'provider' => $this->string(255)->append('COLLATE utf8_unicode_ci')->notNull(),
                'client_id' => $this->string(255)->append('COLLATE utf8_unicode_ci')->notNull(),
                'data' => $this->text()->append('COLLATE utf8_unicode_ci'),
                'code' => $this->string(32)->append('COLLATE utf8_unicode_ci')->null(),
                'created_at' => $this->integer(11)->null(),
                'email' => $this->string(255)->append('COLLATE utf8_unicode_ci')->null(),
                'username' => $this->string(255)->append('COLLATE utf8_unicode_ci')->null(),
                'PRIMARY KEY(`id`)',
            ]
        );

        $this->createTable(
            'token',
            [
                'user_id' => $this->integer(11)->notNull(),
                'code' => $this->string(32)->append('COLLATE utf8_unicode_ci')->notNull(),
                'created_at' => $this->integer(11)->notNull(),
                'type' => $this->smallInteger(6)->notNull(),
            ]
        );

        $this->createTable(
            'user',
            [
                'id' => $this->integer(11)->notNull(),
                'username' => $this->string(255)->append('COLLATE utf8_unicode_ci')->notNull(),
                'email' => $this->string(255)->append('COLLATE utf8_unicode_ci')->notNull(),
                'password_hash' => $this->string(60)->append('COLLATE utf8_unicode_ci')->notNull(),
                'auth_key' => $this->string(32)->append('COLLATE utf8_unicode_ci')->notNull(),
                'confirmed_at' => $this->integer(11)->defaultValue(null),
                'unconfirmed_email' => $this->string(255)->append('COLLATE utf8_unicode_ci')
                    ->defaultValue(null),
                'blocked_at' => $this->integer(11)->null(),
                'registration_ip' => $this->string(45)->append('COLLATE utf8_unicode_ci')
                    ->defaultValue(null),
                'created_at' => $this->integer(11)->notNull(),
                'updated_at' => $this->integer(11)->notNull(),
                'flags' => $this->integer(11)->notNull()->defaultValue(0),
                'last_login_at' => $this->integer(11)->defaultValue(null),
                'PRIMARY KEY(`id`)',
            ]
        );
        $this->batchInsert(
            'user',
            [
                'id', 'username', 'email', 'password_hash', 'auth_key', 'confirmed_at', 'unconfirmed_email',
                'blocked_at', 'registration_ip', 'created_at', 'updated_at', 'flags', 'last_login_at',
            ],
            [
                [
                    1, 'admin', 'admin@localhost.ru', '$2y$10$M74V3Foy5TNDnLRKLC./peW0j0kUeGUQQA81y6T8HRaLhVkglzJT6',
                    '49k8g9BCLZnoOEgIwr5OGnvckwk_IklI', 1512133891, null, null, null, 1512133891, 1512134298,
                    0, 1512328174],
                [
                    2, 'user', 'user@localhost.ru', '$2y$10$WqTO.GkBmkzraLjmwhSYcunwshkBiYufYE6DzIb5jlXeve/gX6.KS',
                    'UPGp7e787qOii-RY3-Tf9Ch1M5BbtrAJ', 1512147430, null, null, '127.0.0.1', 1512147430, 1512147430,
                    0, 1512328121
                ],
            ]
        );


        // Индексы

        $this->createIndex(
            'auth_assignment_user_id_idx',
            'auth_assignment',
            'user_id'
        );
        
        $this->createIndex(
            'rule_name',
            'auth_item',
            'rule_name'
        );
        $this->createIndex(
            'idx-auth_item-type',
            'auth_item',
            'type'
        );
        
        $this->createIndex(
            'child',
            'auth_item_child',
            'child'
        );

        $this->createIndex(
            'account_unique',
            'social_account',
            ['provider', 'client_id'],
            true
        );
        $this->createIndex(
            'account_unique_code',
            'social_account',
            'code',
            true
        );
        $this->createIndex(
            'fk_user_account',
            'social_account',
            'user_id'
        );

        $this->createIndex(
            'token_unique',
            'token',
            ['user_id','code','type'],
            true
        );
        
        $this->createIndex(
            'user_unique_username',
            'user',
            'username',
            true
        );
        $this->createIndex(
            'user_unique_email',
            'user',
            'email',
            true
        );

        // Внешние ключи

        $this->addForeignKey(
            'auth_assignment_ibfk_1',
            'auth_assignment',
            'item_name',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'auth_item_ibfk_1',
            'auth_item',
            'rule_name',
            'auth_rule',
            'name',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'auth_item_child_ibfk_1',
            'auth_item_child',
            'parent',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'auth_item_child_ibfk_2',
            'auth_item_child',
            'child',
            'auth_item',
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_user_profile',
            'profile',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_user_account',
            'social_account',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_user_token',
            'token',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('auth_assignment_ibfk_1', 'auth_assignment');
        $this->dropForeignKey('auth_item_ibfk_1', 'auth_item');
        $this->dropForeignKey('auth_item_child_ibfk_1', 'auth_item_child');
        $this->dropForeignKey('auth_item_child_ibfk_2', 'auth_item_child');
        $this->dropForeignKey('fk_user_profile', 'profile');
        $this->dropForeignKey('fk_user_account', 'social_account');
        $this->dropForeignKey('fk_user_token', 'token');

        $this->dropTable('auth_assignment');
        $this->dropTable('auth_item');
        $this->dropTable('auth_item_child');
        $this->dropTable('auth_rule');
        $this->dropTable('profile');
        $this->dropTable('social_account');
        $this->dropTable('token');
        $this->dropTable('user');

        return true;
    }

}
