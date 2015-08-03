<?php

use yii\db\Schema;
use yii\db\Migration;

class m150723_205743_robotsTable extends Migration
{
    public function up()
    {
        $this->createTable('sitemapModule', [
            'id' => Schema::TYPE_PK,
            'class' => Schema::TYPE_STRING . '(255) NOT NULL',
            'excludedId' => Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('sitemapModule');
    }
}