<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'value' => 'title']) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true, 'value' => '1654876']) ?>

    <?= $form->field($model, 'pageCount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publishedDate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shortDescription')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fileImage')->fileInput() ?>

    <?= $form->field($model, 'status')->textInput(['value' => '1']) ?>

    <?= $form->field($model, 'authors')->textInput(['maxlength' => true, 'value' => 'authors']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
