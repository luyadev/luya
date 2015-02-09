Show Navigation in the Frontend Layout
======================================

To show the navigation tree you need to access the link collection provided by ```Yii::$app```. You have multiple possibilities by changing the arguments of
```Yii::$app->collection->links->findByArguments()```. Assuming a default category, a language variable set in ```$lang->shortCode``` and the id of the parent cms page is 0 (= top level),
you'll get the first hierarchy as an array by calling ```Yii::$app->collection->links->findByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => 0])```

Full Navigation Tree
--------------------

By nesting multiple foreach loops and using the the last item id as the current parent id you can parse the entire navigation tree.

Attention: in production you should check if ```Yii::$app->collection->links->findByArguments(['lang' => $lang->shortCode, 'parent_nav_id' => $item['id']])``` is returning an array and not null before looping.

Example - showing three levels of the navigation tree:
```
<ul>
<? foreach(Yii::$app->collection->links->findByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => 0]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a>
            <ul>
                <? foreach(Yii::$app->collection->links->findByArguments(['lang' => $lang->shortCode, 'parent_nav_id' => $item['id']]) as $subItem): ?>
                <li><a href="<?= $lang->shortCode; ?>/<?=$subItem['url'];?>"><?= $subItem['title']?></a>
                <ul>
                    <? foreach(Yii::$app->collection->links->findByArguments(['lang' => $lang->shortCode, 'parent_nav_id' => $subItem['id']]) as $subSubItem): ?>
                    <li><a href="<?= $lang->shortCode; ?>/<?=$subSubItem['url'];?>"><?= $subSubItem['title']?></a>
                    <? endforeach; ?>
                </ul>
                <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
</ul>
```

Snapshot of the Navigation Tree
-------------------------------

If you want to show only the part of the navigation tree which is currently viewed by the web user, you'll have to determine the active part of each level in the hierarchy by
accessing the helper function ```\luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 1)``` (for level = 1).

Example - showing three levels of the navigation hierarchy:

```
<!-- FIRST LEVEL -->
<ul>
    <? foreach(Yii::$app->collection->links->findByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 1)]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a></li>
    <? endforeach; ?>
</ul>

<!-- SECOND LEVEL -->
<ul>
    <? foreach(Yii::$app->collection->links->findByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 2)]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a></li>
    <? endforeach; ?>
</ul>

<!-- THIRD LEVEL -->
 <ul>
    <? foreach(Yii::$app->collection->links->findByArguments(['cat' => 'default', 'lang' => $lang->shortCode, 'parent_nav_id' => \luya\helpers\Menu::parentNavIdByCurrentLink(\yii::$app->collection->links, 3)]) as $item): ?>
        <li><a href="<?= $lang->shortCode; ?>/<?=$item['url'];?>"><?= $item['title']; ?></a></li>
    <? endforeach; ?>
</ul>
```