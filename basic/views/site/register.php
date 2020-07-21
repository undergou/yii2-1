<?php 
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Sign up';
?>

<h1>Registration</h1>

<?php if(Yii::$app->session->hasFlash('exist')) :?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <?= Yii::$app->session->getFlash('exist')?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if(Yii::$app->session->hasFlash('bad')) :?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <?=Yii::$app->session->getFlash('bad')?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['id' => 'register']); ?>

<?= $form->field($model, 'username', ['inputOptions' => ['id' => 'register-username', 'style' => 'margin-left: 28px']]) ?>
<?= $form->field($model, 'displayname', ['inputOptions' => ['id' => 'register-displayname']]) ?>
<?= $form->field($model, 'email', ['inputOptions' => ['id' => 'register-email', 'style' => 'margin-left: 25px']]) ?>
<?= $form->field($model, 'password', ['inputOptions' => ['id' => 'register-password']])->input('password') ?>
<?= Html::submitButton("Submit", ['class' => 'btn btn-primary'])?>

<?php $form=ActiveForm::end(); ?>

