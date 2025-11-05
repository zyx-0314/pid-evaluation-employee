<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\User;

/**
 * AdminController
 *
 * Provides simple admin UI for managing users: list, create, update, block/unblock,
 * soft-delete and update status. This implementation uses the existing `is_active`
 * column for active/blocked state and performs a non-destructive "soft delete"
 * by disabling the account and appending a suffix to username/email to avoid collisions.
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'toggle-active' => ['post'],
                    'soft-delete' => ['post'],
                    'update-status' => ['post'],
                    'create' => ['get','post'],
                    'update' => ['get','post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        // Only allow admin role to access these actions. If there is no logged-in
        // user or the role is not 'admin', block access.
        $user = Yii::$app->user->identity ?? null;
        if (!$user || ($user->role ?? null) !== 'admin') {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all users (including inactive)
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => ['pageSize' => 25],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create new user
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            // Set password if provided in `password` attribute
            if (Yii::$app->request->post('User')['password'] ?? null) {
                $model->setPassword(Yii::$app->request->post('User')['password']);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User created');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Update an existing user (all data)
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // If password field is present and non-empty, update password
            if (Yii::$app->request->post('User')['password'] ?? null) {
                $model->setPassword(Yii::$app->request->post('User')['password']);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User updated');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Toggle active/blocked state (block/unblock)
     */
    public function actionToggleActive($id)
    {
        $model = $this->findModel($id);
        $model->is_active = !$model->is_active;
        $model->save(false, ['is_active', 'updated_at']);
        Yii::$app->session->setFlash('success', 'User status changed');
        return $this->redirect(['index']);
    }

    /**
     * Soft delete: mark inactive and modify username/email to avoid collisions.
     */
    public function actionSoftDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->is_active) {
            $model->is_active = false;
        }
        $suffix = '_deleted_' . $model->id . '_' . time();
        $model->username = substr($model->username, 0, 180) . $suffix;
        $model->email = substr($model->email, 0, 180) . $suffix . '@deleted.local';
        $model->save(false);
        Yii::$app->session->setFlash('success', 'User soft-deleted');
        return $this->redirect(['index']);
    }

    /**
     * Update only status (is_active or role)
     */
    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if (isset($post['is_active'])) {
            $model->is_active = (bool)$post['is_active'];
        }
        if (isset($post['role'])) {
            $model->role = $post['role'];
        }
        if ($model->save(false, ['is_active', 'role', 'updated_at'])) {
            Yii::$app->session->setFlash('success', 'User status updated');
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested user does not exist.');
    }
}
