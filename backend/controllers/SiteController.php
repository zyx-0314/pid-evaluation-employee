<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;

/**
 * Site controller
 * 
 * Handles main site pages including login/logout (LILO)
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Display home page
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action
     * 
     * Part of LILO (Login/Logout) scenario for acceptance testing
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isPost) {
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');

            $user = User::findByUsername($username);
            if ($user && $user->validatePassword($password)) {
                Yii::$app->user->login($user);
                return $this->goBack();
            }

            Yii::$app->session->setFlash('error', 'Incorrect username or password.');
        }

        return $this->render('login');
    }

    /**
     * Logout action
     * 
     * Part of LILO (Login/Logout) scenario for acceptance testing
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Error action
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
