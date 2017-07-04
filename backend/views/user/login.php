


<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录到后台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'remember')->checkbox() ?>
            <?= $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
                'captchaAction'=>'user/captcha',
                'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>'])?>

            <div class="form-group">
                <?= \yii\bootstrap\Html::submitInput('登录',['class'=>'btn btn-info']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

