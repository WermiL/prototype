<?php

use yii\db\Migration;

class m210310_145353_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'nickname' => $this->string()->notNull()->unique(),
            'first_name' => $this->string()->null()->defaultValue(null),
            'last_name' => $this->string()->null()->defaultValue(null),
            'auth_key' => $this->string(32)->notNull(),
            'verification_token' => $this->string()->null()->defaultValue(null),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->null()->defaultValue(null)->unique(),
            'status' => $this->tinyInteger()->unsigned()->notNull()->defaultValue(9),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
