<?php

namespace app\models;

use Dersonsena\JWTTools\JWTTools;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $auth_key
 * @property string|null $reset_token
 * @property int $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['auth_key'], 'string'],
            [['status'], 'integer'],
            [['name', 'email', 'password'], 'string', 'max' => 60],
            [['reset_token'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'reset_token' => 'Reset Token',
            'status' => 'Status',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['auth_key'], $fields['reset_token']);

        return $fields;
    }

    public function validatePassword(string $password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $decodedToken = JWTTools::build(Yii::$app->params['jwt']['secret'])
            ->decodeToken($token);

        return static::findOne(['id' => $decodedToken->sub]);
    }
}
