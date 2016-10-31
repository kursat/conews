<?php

use yii\db\Migration;

/**
 * Handles the creation for table `post`.
 */
class m161030_170244_create_post_table extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'content' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
                ], $tableOptions);


        $this->addForeignKey('post_user_id_fkey', '{{%post}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down() {

        $this->dropForeignKey('post_user_id_fkey', '{{%post}}');
        $this->dropTable('{{%post}}');
    }

}
