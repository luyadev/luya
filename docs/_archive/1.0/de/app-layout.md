Projekt Layout
==============

> Damit sind nicht die *CMS Layouts* gemeint sondern die Yii layouts.

Das Projekt Layout befindet sich im Ornder `views/layouts/main.php`.

Module Link
===========
Ein Link zu einem Module welches via CMS implenetiert wurde, zbsp. die Suchmaske welche zum Module `crawler` linken soll nach dem Submit:

```
<form method="get" action="<?= cms\helpers\Url::toModule('crawler'); ?>">
    <input type="text" name="query" />
    <input type="submit" value="Go" />
</form>
```