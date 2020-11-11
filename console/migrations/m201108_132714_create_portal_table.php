<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%portal}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%added_by}}`
 */
class m201108_132714_create_portal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%portal}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256)->comment('Название портала'),
            'url' => $this->string(256)->comment('Адрес портала'),
            'description' => $this->text()->comment('Описание портала'),
            'status' => $this->integer(1)->comment('Статус портала'),
            'added_by' => $this->integer()->comment('Добавивший пользователь'),
            'date_added' => $this->dateTime()->comment('Дата добавления'),
            'logo_name' => $this->string(512)->comment('Логотип портала'),
        ]);

        // creates index for column `added_by`
        $this->createIndex(
            '{{%idx-portal-added_by}}',
            '{{%portal}}',
            'added_by'
        );

        // add foreign key for table `{{%added_by}}`
        $this->addForeignKey(
            '{{%fk-portal-added_by}}',
            '{{%portal}}',
            'added_by',
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
        // drops foreign key for table `{{%added_by}}`
        $this->dropForeignKey(
            '{{%fk-portal-added_by}}',
            '{{%portal}}'
        );

        // drops index for column `added_by`
        $this->dropIndex(
            '{{%idx-portal-added_by}}',
            '{{%portal}}'
        );

        $this->dropTable('{{%portal}}');
    }
}
