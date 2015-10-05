<h1>Hallo <?= $model->firstname; ?> <?= $model->lastname; ?></h1>
<p>Einloggt als <?= $model->email; ?>.</p>
<a href="<?= \luya\helpers\Url::to('account/default/logout'); ?>">Ausloggen</a>