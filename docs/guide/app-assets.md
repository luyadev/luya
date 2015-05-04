App Assets
==========

create an asset class extend from yii\web\AssetBundle:
```php
namespace app\assets;

class LuyaioAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/files';
    
    public $css = [
        "css/style.css",
    ];
    
    public $publishOptions = ['forceCopy' => true];
}
```

register the asset inside the view:
```php
$luyaio = \app\assets\LuyaioAsset::register($this);
```

accessing images inside the asset folder:
```php
<img src="<?= $luyaio->baseUrl; ?>img/teaser.png" border="0" />
```