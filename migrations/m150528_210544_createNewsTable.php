<?php

use yii\db\Schema;
use yii\db\Migration;

class m150528_210544_createNewsTable extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        
        $this->createTable('{{%news}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING. ' NOT NULL',
            'description' => Schema::TYPE_STRING . ' NOT NULL',
            'text' => Schema::TYPE_TEXT,
            'active' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT TRUE',
            'createdAt' => Schema::TYPE_INTEGER.' NOT NULL',
            'hasImage' => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT FALSE',
            'imageExtension' => "CHAR(5) NOT NULL DEFAULT ''"
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%news}}');
    }
    
}
