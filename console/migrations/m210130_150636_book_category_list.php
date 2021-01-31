<?php

use yii\db\Migration;

/**
 * Class m210130_150636_book_category_list
 */
class m210130_150636_book_category_list extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book_category_list}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->string()->notNull(),
            'book_id' => $this->string()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m210130_133642_category cannot be reverted.\n";

        return false;
    }
}