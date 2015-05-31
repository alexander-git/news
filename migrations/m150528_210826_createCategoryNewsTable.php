<?php

use yii\db\Schema;
use yii\db\Migration;

class m150528_210826_createCategoryNewsTable extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        
        $this->createTable('{{%categorynews}}', [
            'idCategory' => Schema::TYPE_INTEGER,
            'idNews' => Schema::TYPE_INTEGER
        ], $tableOptions);
        
        $this->addForeignKey('categoryFK', '{{%categoryNews}}', 'idCategory', '{{%category}}', 'id', 'RESTRICT');
        $this->addForeignKey('newsFK', '{{%categoryNews}}', 'idNews', '{{%news}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%categorynews}}');
    }
    
}
