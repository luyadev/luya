Creating Menus in the Frontend Layout
=====================================

Full Navigation
---------------

this is an example if you want to get the full navigation tree at once (attention: isset() and empty() should be checked in production, cause uf empty ul tags!)

```
<ul>
<? foreach(Yii::$app->collection->links->getByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => 0]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a> <small>(<?= $item['url'];?>)</small>
            <ul>
                <? foreach(Yii::$app->collection->links->getByArguments(['lang' => $lang->shortCode, 'parent_nav_id' => $item['id']]) as $subItem): ?>
                <li><a href="<?= $lang->shortCode; ?>/<?=$subItem['url'];?>"><?= $subItem['title']?></a> <small>(<?= $subItem['url'];?>)</small>
                
                <ul>
                    <? foreach(Yii::$app->collection->links->getByArguments(['lang' => $lang->shortCode, 'parent_nav_id' => $subItem['id']]) as $subSubItem): ?>
                    <li><a href="<?= $lang->shortCode; ?>/<?=$subSubItem['url'];?>"><?= $subSubItem['title']?></a> <small>(<?= $subSubItem['url'];?>)</small>
                    <? endforeach; ?>
                </ul>
                
                <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
</ul>
```

Splitted Navigation
-------------------

this is an example of a navigation based on the splitted parts which are display only if the current element does have child elements:

```
FIRST
<ul>
    <? foreach(Yii::$app->collection->links->getByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 1)]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a> <small>(<?= $item['url'];?>)</small></li>
    <? endforeach; ?>
</ul>
SECOND
<ul>
    <? foreach(Yii::$app->collection->links->getByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 2)]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a> <small>(<?= $item['url'];?>)</small></li>
    <? endforeach; ?>
    
</ul>
THIRD
 <ul>
    <? foreach(Yii::$app->collection->links->getByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 3)]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a> <small>(<?= $item['url'];?>)</small></li>
    <? endforeach; ?>
    
</ul>
```