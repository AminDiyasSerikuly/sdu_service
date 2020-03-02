<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card">
    <div class="book-form card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'dir_name')->dropDownList(
            [
                1 => '(id-номер) + username',
                2 => '(id-номер) + created_date',
                3 => '(id-номер) + directory_name'
            ]
        ); ?>
        <?= $form->field($model, 'format')->dropDownList(
            [
                1 => '.WAV',
                2 => 'MP4',
            ]
        ) ?>
        <?= FileUploadUI::widget([
            'model' => $model,
            'attribute' => 'image',
            'url' => ['book/image-upload', 'id' => $model->id],
            'gallery' => false,
            'fieldOptions' => [
                'accept' => 'image/*'
            ],
            'clientOptions' => [
                'maxFileSize' => 2000000
            ],
            // ...
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
                'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
            ],
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
