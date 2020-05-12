<?php

namespace app\controllers;

use Dersonsena\JWTTools\JWTTools;
use Yii;
use app\models\User;

class UsersController extends ControllerBase
{
    public $modelClass = 'app\models\User';

    public function actionLogin()
    {
        $email = Yii::$app->getRequest()->get('email');
        $password = Yii::$app->getRequest()->get('password');

        if (!$email || empty($email)) {
            return ['success' => false, 'message' => 'Campo e-mail é obrigatório.'];
        }

        if (!$password || empty($password)) {
            return ['success' => false, 'message' => 'Campo senha é obrigatório.'];
        }

        $user = User::findOne(['email' => $email]);

        if (!$user) {
            return ['success' => false, 'message' => 'E-mail informado é inválido'];
        }

        if (!Yii::$app->getSecurity()->validatePassword($password, $user->password)) {
            return ['success' => false, 'message' => 'E-mail e/ou senha inválidos.'];
        }

        $token = JWTTools::build(Yii::$app->params['jwt']['secret'])
            ->withModel($user, ['name', 'email', 'status'])
            ->getJWT();

        return ['success' => true, 'token' => $token];
    }
}