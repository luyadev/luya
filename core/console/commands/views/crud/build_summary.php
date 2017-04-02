public $apis = [
    '<?= $apiEndpoint; ?>' => '<?= $apiClassPath; ?>',
];

public function getMenu()
{
    return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('<?= $humanizeModelName; ?>', 'extension')
            ->group('Group')
                ->itemApi('<?= $humanizeModelName; ?>', '<?= $controllerRoute; ?>', 'label', '<?= $apiEndpoint; ?>');
}