<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_company_web_company_service}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%web_company}}`
 * - `{{%web_company_service}}`
 */
class m210406_213736_create_junction_table_for_web_company_and_web_company_service_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_company_web_company_service}}', [
            'web_company_id' => $this->integer(),
            'web_company_service_id' => $this->integer(),
            'PRIMARY KEY(web_company_id, web_company_service_id)',
        ]);

        // creates index for column `web_company_id`
        $this->createIndex(
            '{{%idx-web_company_web_company_service-web_company_id}}',
            '{{%web_company_web_company_service}}',
            'web_company_id'
        );

        // add foreign key for table `{{%web_company}}`
        $this->addForeignKey(
            '{{%fk-web_company_web_company_service-web_company_id}}',
            '{{%web_company_web_company_service}}',
            'web_company_id',
            '{{%web_company}}',
            'id',
            'CASCADE'
        );

        // creates index for column `web_company_service_id`
        $this->createIndex(
            '{{%idx-web_company_web_company_service-web_company_service_id}}',
            '{{%web_company_web_company_service}}',
            'web_company_service_id'
        );

        // add foreign key for table `{{%web_company_service}}`
        $this->addForeignKey(
            '{{%fk-web_company_web_company_service-web_company_service_id}}',
            '{{%web_company_web_company_service}}',
            'web_company_service_id',
            '{{%web_company_service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%web_company}}`
        $this->dropForeignKey(
            '{{%fk-web_company_web_company_service-web_company_id}}',
            '{{%web_company_web_company_service}}'
        );

        // drops index for column `web_company_id`
        $this->dropIndex(
            '{{%idx-web_company_web_company_service-web_company_id}}',
            '{{%web_company_web_company_service}}'
        );

        // drops foreign key for table `{{%web_company_service}}`
        $this->dropForeignKey(
            '{{%fk-web_company_web_company_service-web_company_service_id}}',
            '{{%web_company_web_company_service}}'
        );

        // drops index for column `web_company_service_id`
        $this->dropIndex(
            '{{%idx-web_company_web_company_service-web_company_service_id}}',
            '{{%web_company_web_company_service}}'
        );

        $this->dropTable('{{%web_company_web_company_service}}');
    }
}
