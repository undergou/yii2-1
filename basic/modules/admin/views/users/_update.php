<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['id' => 'update']); ?>

    <?= $form->field($model, 'username', ['inputOptions' => ['id' => 'update-username', 'style' => 'margin-left: 18px']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email', ['inputOptions' => ['id' => 'update-email', 'style' => 'margin-left: 49px']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'displayname', ['inputOptions' => ['id' => 'update-displayname']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password', ['inputOptions' => ['id' => 'update-password', 'style' => 'margin-left: 20px']])->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
