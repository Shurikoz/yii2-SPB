<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Feedback';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?= Alert::widget() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'feedback-form']); ?>

            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'phone') ?>

            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'reCaptcha')->widget(
                \himiklab\yii2\recaptcha\ReCaptcha::className(),
                ['siteKey' => '6LfKlUIaAAAAAPcnJ9uYTXP4giUWiB3iucZBieIv']
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
