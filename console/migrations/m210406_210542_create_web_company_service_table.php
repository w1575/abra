<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_company_service}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210406_210542_create_web_company_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_company_service}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Название услуги')->notNull(),
            'date_created' => $this->dateTime()->comment('Дата добавления'),
            'creator_id' => $this->integer()->comment('Создатель'),
            'status' => $this->tinyInteger(2)->comment('Статус [-1 - удалена, 0 - неактивна, 1- активна]')->defaultValue(1),
            'description' => $this->string()->comment('Описание')
        ]);

        // creates index for column `creator_id`
        $this->createIndex(
            '{{%idx-web_company_service-creator_id}}',
            '{{%web_company_service}}',
            'creator_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-web_company_service-creator_id}}',
            '{{%web_company_service}}',
            'creator_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-web_company_service-creator_id}}',
            '{{%web_company_service}}'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            '{{%idx-web_company_service-creator_id}}',
            '{{%web_company_service}}'
        );

        $this->dropTable('{{%web_company_service}}');
    }
}
