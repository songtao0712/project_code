<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/17
 * Time: 9:39
 */

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'role')->checkboxList(\backend\models\UserRoleForm::getRoleOptions());
echo \yii\helpers\Html::submitButton('添加角色',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();