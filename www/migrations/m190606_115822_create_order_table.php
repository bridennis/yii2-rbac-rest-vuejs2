<?php

use app\migrations\BaseMigration;

/**
 * Handles the creation of table order.
 */
class m190606_115822_create_order_table extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'order_date' => $this->date()->notNull(),
            'descr' => $this->string(255)->notNull()->append('COLLATE utf8_unicode_ci'),
            'cost' => $this->decimal(20, 2)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
        ]);
        $this->batchInsert(
            'order',
            [
                'id', 'order_date', 'descr', 'cost', 'user_id',
            ],
            [
                [3, '2017-12-03', 'состав заказа #3', '2.50', 1],
                [9, '2017-12-03', 'состав заказа #9', '90.00', 1],
                [10, '2017-12-01', 'состав заказа #10', '1.00', 2],
                [11, '2017-12-02', 'состав заказа #11', '200.20', 2],
                [12, '2017-12-03', 'состав заказа #12', '1.00', 2],
                [14, '2017-12-02', 'состав заказа #14', '100.00', 1],
                [15, '2017-12-03', 'состав заказа #15', '1.23', 1],
                [16, '2017-12-03', 'состав заказа #16', '4.50', 1],
                [17, '2017-12-03', 'состав заказа #17', '1000000.00', 1],
            ]
        );

        // Индексы

        $this->createIndex(
            'dt_created',
            'order',
            'order_date'
        );
        $this->createIndex(
            'user_id',
            'order',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }
}
