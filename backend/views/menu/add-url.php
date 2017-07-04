<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/18
 * Time: 12:48
 */

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'lable');
echo $form->field($model,'url');
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getParentMenuOption(),['prompt'=>'请选择一级菜单，若不选则默认为一级菜单。']);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('提交路由',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();