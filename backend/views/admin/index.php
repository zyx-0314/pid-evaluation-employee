<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create new user', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'email:email',
            'role',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->is_active ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>';
                }
            ],
            'last_login',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {toggle} {soft} {status}',
                'buttons' => [
                    'toggle' => function($url, $model) {
                        $label = $model->is_active ? 'Block' : 'Unblock';
                        return Html::a($label, ['toggle-active', 'id' => $model->id], ['data' => ['method' => 'post'], 'class' => 'btn btn-warning btn-xs']);
                    },
                    'soft' => function($url, $model) {
                        return Html::a('Soft Delete', ['soft-delete', 'id' => $model->id], ['data' => ['method' => 'post', 'confirm' => 'Soft delete this user? This will disable the account.'], 'class' => 'btn btn-danger btn-xs']);
                    },
                    'status' => function($url, $model) {
                        // quick role toggle form
                        $options = Html::beginForm(['update-status', 'id' => $model->id], 'post', ['style' => 'display:inline-block;margin-left:5px;']);
                        $options .= Html::dropDownList('role', $model->role, ['admin' => 'admin', 'manager' => 'manager', 'employee' => 'employee'], ['class' => 'form-control', 'style' => 'display:inline-block;width:auto;padding:2px 6px;']);
                        $options .= Html::submitButton('Set', ['class' => 'btn btn-primary btn-xs']);
                        $options .= Html::endForm();
                        return $options;
                    }
                ]
            ],
        ],
    ]); ?>
</div>
