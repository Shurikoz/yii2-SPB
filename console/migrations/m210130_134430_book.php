<?php

use yii\db\Migration;

/**
 * Class m210130_134430_book
 */
class m210130_134430_book extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->null(),
            'isbn' => $this->string()->null(),
            'pageCount' => $this->string()->null(),
            'publishedDate' => $this->string()->null(),
            'thumbnailUrl' => $this->string()->null(),
            'shortDescription' => $this->string()->null(),
            'longDescription' => $this->text()->null(),
            'status' => $this->string(10)->notNull(),
            'authors' => $this->string()->null(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m210130_133642_category cannot be reverted.\n";

        return false;
    }
};
