<?php 
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = 'Retrieve password';
?>
<h1>Reset your password</h1>
<?php $form = ActiveForm::begin(['id' => 'restore']); ?>

<?= $form->field($model, 'newPassword', ['inputOptions' => ['id' => 'restore-newpassword']])->input('password') ?>
<?= Html::submitButton("Submit", ['class' => 'btn btn-primary'])?>

<?php $form=ActiveForm::end(); ?>