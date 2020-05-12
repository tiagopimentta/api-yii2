<?php

namespace app\controllers;

use Yii;
use Dersonsena\JWTTools\JWTSignatureBehavior;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

abstract class ControllerBase extends ActiveController
{
    public function actions()
    {
        return array_merge(parent::actions(), [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ]);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['jwtValidator'] = [
            'class' => JWTSignatureBehavior::class,
            'secretKey' => Yii::$app->params['jwt']['secret'],
            'except' => ['login']
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login']
        ];

        $behaviors['cors'] = [
            'class' => Cors::class
        ];

        return $behaviors;
    }
}