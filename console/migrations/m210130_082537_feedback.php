<?php

use yii\db\Migration;

/**
 * Class m210130_082537_feedback
 */
class m210130_082537_feedback extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%feedback}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'phone' => $this->text(),
            'message' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        echo "m210130_082537_feedback cannot be reverted.\n";

        return false;
    }
}
