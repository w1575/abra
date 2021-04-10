<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_company}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%creator}}`
 */
class m210406_213243_create_web_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Название')->notNull(),
            'url' => $this->string(255)->comment('Ссылка на сайт'),
            'description' => $this->string(255)->comment('Описание'),
            'creator_id' => $this->integer()->comment('Создатель'),
            'status' => $this->tinyInteger(2)->comment('Статус')->defaultValue(1),
            'logo_path' => $this->string(512)->comment('Логотип'),
        ]);

        // creates index for column `creator_id`
        $this->createIndex(
            '{{%idx-web_company-creator_id}}',
            '{{%web_company}}',
            'creator_id'
        );

        // add foreign key for table `{{%creator}}`
        $this->addForeignKey(
            '{{%fk-web_company-creator_id}}',
            '{{%web_company}}',
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
        // drops foreign key for table `{{%creator}}`
        $this->dropForeignKey(
            '{{%fk-web_company-creator_id}}',
            '{{%web_company}}'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            '{{%idx-web_company-creator_id}}',
            '{{%web_company}}'
        );

        $this->dropTable('{{%web_company}}');
    }
}
