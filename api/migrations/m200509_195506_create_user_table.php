<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200509_195506_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'email' => $this->string(60)->notNull(),
            'password' => $this->string(60)->notNull(),
            'reset_token' => $this->string(100)->defaultValue(null),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1)
        ]);

        $this->insert("{{%users}}", [
            'name' => 'Administrador',
            'email' => 'admin@admin.com.br',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('123456')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
