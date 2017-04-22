<?php
/**
 * @var $this \luya\cms\base\PhpBlockView
*/
?>
<?php if (!empty($this->varValue('address'))):?>
<div class="embed-responsive embed-responsive-16by9">
    <iframe src="https://maps.google.com/maps?f=q&source=s_q&hl=de&geocode=&q=<?= $this->extraValue('address');?>&z=<?= $this->extraValue('zoom');?>&t=<?= $this->extraValue('maptype')?>&output=embed" width="600" height="450" frameborder="0" style="border:0"></iframe>
</div>
<?php endif; ?>