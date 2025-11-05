<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Admin Dashboard';
?>

<div class="bg-white rounded-lg shadow-md p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Employee Evaluation System</h1>
    
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                <h3 class="text-xl font-semibold text-blue-800 mb-2">Employees</h3>
                <p class="text-gray-600">Manage employee records</p>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                <h3 class="text-xl font-semibold text-green-800 mb-2">Evaluations</h3>
                <p class="text-gray-600">View and create evaluations</p>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                <h3 class="text-xl font-semibold text-purple-800 mb-2">Reports</h3>
                <p class="text-gray-600">Generate reports</p>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-8">
            <p class="text-gray-700">Please <?= Html::a('login', ['site/login'], ['class' => 'text-blue-600 hover:underline']) ?> to access the admin panel.</p>
        </div>
    <?php endif; ?>
</div>
