<?php

use yii\db\Schema;
use yii\db\Migration;

class m150528_210420_createCategoryTable extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        
        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_STRING,
            'active' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT TRUE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%category}}');
    }
   
}
