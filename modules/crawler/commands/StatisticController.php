<?php

namespace crawler\commands;

use Yii;
use luya\console\Command;
use crawleradmin\models\Searchdata;
use yii\console\Exception;

class StatisticController extends Command
{
    public function actionIndex()
    {
        if (empty($this->module->statisticRecipients)) {
            throw new Exception("You have to define at least one statisticRecipients in your configuration to send the stats mail.");
        }
        
        $lastWeek = strtotime("-1 week");

        $results = Searchdata::find()->where(['>=', 'timestamp', $lastWeek])->asArray()->all();
        
        $data = [
            'noresults' => [],
            'results' => [],
        ];
        
        foreach ($results as $query) {
            if (empty($query['results'])) {
                $data['noresults'][] = $query;
            } else {
                $data['results'][] = $query;
            }
        }
        
        
        $html = '<h1>Search Analtics from '. date("d.m.Y", $lastWeek) . ' until '.date("d.m.Y", time()).'</h1>';
        $html.= '<p>Number of searches: <strong>'.count($results).'</strong></p>';
        $html.= '<p>Querys without results:</p><table border="1">';
        foreach ($data['noresults'] as $item) {
            $html.= '<tr><td>'.$item['query'].'</td><td>'.$item['language'].'</td><td>'. date("d.m.Y", $item['timestamp']).'</td></tr>';
        }
        $html.='</table>';
        
        $html.= '<p>Querys with results:</p><table border="1">';
        foreach ($data['results'] as $item) {
            $html.= '<tr><td>'.$item['query'].'</td><td>'.$item['results'].'</td><td>'.$item['language'].'</td><td>'. date("d.m.Y", $item['timestamp']).'</td></tr>';
        }
        $html.='</table>';
        
        Yii::$app->mail->compose('Search Analtics from '. date("d.m.Y", $lastWeek) . ' until '.date("d.m.Y", time()), $html)->addresses($this->module->statisticRecipients)->send();
        
        return $this->outputSuccess('statis sent!');
    }
}