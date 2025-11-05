<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <?php $this->head() ?>
</head>
<body class="bg-gray-100">
<?php $this->beginBody() ?>

<nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">PID Employee Evaluation - Admin</h1>
        <div>
            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('Login', ['site/login'], ['class' => 'px-4 py-2 bg-blue-700 rounded hover:bg-blue-800']) ?>
            <?php else: ?>
                <span class="mr-4">Welcome, <?= Html::encode(Yii::$app->user->identity->username) ?></span>
                <?= Html::a('Logout', ['site/logout'], ['class' => 'px-4 py-2 bg-blue-700 rounded hover:bg-blue-800']) ?>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mx-auto mt-8 px-4">
    <?= $content ?>
</div>

<footer class="mt-16 py-8 bg-gray-800 text-white text-center">
    <p>&copy; <?= date('Y') ?> PID Employee Evaluation System</p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
