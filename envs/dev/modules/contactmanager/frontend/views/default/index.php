<?php
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;
use luya\helpers\Url as LuyaUrl;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<!-- MAIL SUCCESS MESSAGE - ERROR MESSAGE AVAILABLE IN custom.js -->
<p class="text-success "></p>
<p class="text-danger"></p>
<?php
$form = ActiveForm::begin([
        'id' => 'contact-form',
        'action' => 'contactmanager/default/contact',
        'options' => [
            'class' => 'contact-form',
        ],
        'fieldConfig' => [
            'enableLabel' => false
        ]
    ]);
?>
luya url: <?= Url::to('/contactmanager/default/captcha'); ?><br />
yii url:  <?= LuyaUrl::to('/contactmanager/default/captcha'); ?>
<?=
$form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'captchaAction' => '/contactmanager/default/captcha',
        'template' => '<div class="form-group has-feedback row"><div class="col-md-3">{image}</div><div class="col-md-9">{input}</div></div>',
        'options' => ['placeholder' => Yii::t('app', 'hint_verfication_code'), 'class' => 'form-control'],
])
?>
