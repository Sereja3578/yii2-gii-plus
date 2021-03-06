<?php

use yii\jui\autosearch\AutoComplete;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator pvsaintpe\gii\plus\generators\custom\model\Generator */

echo $form->field($generator, 'baseModelClass')->widget(AutoComplete::class, [
    'source' => $generator->getBaseModelClassAutoComplete()
]);
