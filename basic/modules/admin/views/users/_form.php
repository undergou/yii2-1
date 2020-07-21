<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['id' => 'register']); ?>

    <?= $form->field($model, 'username', ['inputOptions' => ['id' => 'register-username', 'style' => 'margin-left: 28px']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email', ['inputOptions' => ['id' => 'register-email', 'style' => 'margin-left: 24px']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'displayname', ['inputOptions' => ['id' => 'register-displayname']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password', ['inputOptions' => ['id' => 'register-password']])->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
