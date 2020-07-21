<?php 
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Retrieve password';
?>

<h1>Retrieve password</h1>
<?php if(Yii::$app->session->hasFlash('Error2')) :?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <?= Yii::$app->session->getFlash('Error2')?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php if(Yii::$app->session->hasFlash('Good2')) :?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= Yii::$app->session->getFlash('Good2')?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['id' => 'restore']); ?>

<?= $form->field($model, 'email', ['inputOptions' => ['id' => 'restore-email']])->textInput(['autofocus' => true]) ?>
<?= Html::submitButton("Recover", ['class' => 'btn btn-primary'])?>

<?php $form=ActiveForm::end(); ?>