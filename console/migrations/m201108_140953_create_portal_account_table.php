<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%portal_account}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%portal}}`
 * - `{{%user}}`
 */
class m201108_140953_create_portal_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%portal_account}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(128)->comment('Имя/адрес электронной почты'),
            'password' => $this->string(64)->comment('Пароль'),
            'description' => $this->text()->comment('Описание/дополнительная информация'),
            'portal_id' => $this->integer()->comment('Портал'),
            'date_added' => $this->dateTime()->comment('Дата добавления'),
            'status' => $this->tinyInteger()->comment('Статус аккаунта'),
            'added_by' => $this->integer()->comment('Добавил пользователь'),
        ]);

        // creates index for column `portal_id`
        $this->createIndex(
            '{{%idx-portal_account-portal_id}}',
            '{{%portal_account}}',
            'portal_id'
        );

        // add foreign key for table `{{%portal}}`
        $this->addForeignKey(
            '{{%fk-portal_account-portal_id}}',
            '{{%portal_account}}',
            'portal_id',
            '{{%portal}}',
            'id',
            'CASCADE'
        );

        // creates index for column `added_by`
        $this->createIndex(
            '{{%idx-portal_account-added_by}}',
            '{{%portal_account}}',
            'added_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-portal_account-added_by}}',
            '{{%portal_account}}',
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
        // drops foreign key for table `{{%portal}}`
        $this->dropForeignKey(
            '{{%fk-portal_account-portal_id}}',
            '{{%portal_account}}'
        );

        // drops index for column `portal_id`
        $this->dropIndex(
            '{{%idx-portal_account-portal_id}}',
            '{{%portal_account}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-portal_account-added_by}}',
            '{{%portal_account}}'
        );

        // drops index for column `added_by`
        $this->dropIndex(
            '{{%idx-portal_account-added_by}}',
            '{{%portal_account}}'
        );

        $this->dropTable('{{%portal_account}}');
    }
}
