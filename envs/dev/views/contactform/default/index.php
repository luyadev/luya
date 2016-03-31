<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var object $model Contains the model object based on DynamicModel yii class.
 * @var boolean $success Return true when successfull sent mail and validated
 */
?>

<?php if ($success): ?>
    <div class="alert alert-success">The form has been submited successfull.</div>
<?php else: ?>
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name'); ?>
    <?= $form->field($model, 'message')->textarea(); ?>
    
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    
    <?php ActiveForm::end(); ?>
<?php endif; ?>