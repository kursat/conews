<?php

use yii\db\Migration;

class m161030_170236_create_user_table extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(255),
            'lastname' => $this->string(255),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
                ], $tableOptions);

        $authManager = Yii::$app->getAuthManager();

        $this->addForeignKey('auth_assignment_user_id_fkey', $authManager->assignmentTable, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down() {

        $authManager = Yii::$app->getAuthManager();

        $this->dropForeignKey('auth_assignment_user_id_fkey', $authManager->assignmentTable);
        $this->dropTable('{{%user}}');
    }

}
