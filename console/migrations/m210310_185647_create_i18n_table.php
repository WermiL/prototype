<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use yii\db\Migration;

class m210310_185647_create_i18n_table extends Migration
{
    public function up()
    {

        $this->createTable('{{%i18n_source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),
        ]);

        $this->createTable('{{%i18n_message}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text()->notNull()->defaultValue(''),
        ]);

        $this->addPrimaryKey('pk_i18n_message_id_language', '{{%i18n_message}}', ['id', 'language']);
        $this->addForeignKey('fk_i18n_message_i18n_source_message', '{{%i18n_message}}', 'id', '{{%i18n_source_message}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('idx_i18n_source_message_category', '{{%i18n_source_message}}', 'category');
        $this->createIndex('idx_i18n_message_language', '{{%i18n_message}}', 'language');
    }

    public function down()
    {
        $this->dropForeignKey('fk_i18n_message_i18n_source_message', '{{%i18n_message}}');
        $this->dropTable('{{%i18n_message}}');
        $this->dropTable('{{%i18n_source_message}}');
    }
}
