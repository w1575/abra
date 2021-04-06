<?php

use yii\db\Migration;

/**
 * Class m210406_214841_insert_web_company_services_data
 */
class m210406_214841_insert_web_company_services_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $dateTime = (new DateTime())->format('Y-m-d h:i:s');

        $this->batchInsert(
            '{{%web_company_service}}',
            ['id', 'name', 'date_created', 'description', 'status', 'creator_id'],
            [
                [1, 'Хостинг-провайдер', $dateTime, 'Услуги VPS, VDS, хостинг, облачные технологии', 1, 1],
                [2, 'Регистратор доменов', $dateTime, 'Регистрация доменных имен', 1, 1],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%web_company_service}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210406_214841_insert_web_company_services_data cannot be reverted.\n";

        return false;
    }
    */
}
