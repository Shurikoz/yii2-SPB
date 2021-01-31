<?php

use yii\db\Migration;

/**
 * Class m210130_133642_category
 */
class m210130_133642_category extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'parent_id' => $this->string()->null(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m210130_133642_category cannot be reverted.\n";

        return false;
    }
}
