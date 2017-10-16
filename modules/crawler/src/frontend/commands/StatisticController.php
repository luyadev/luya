<?php

namespace luya\crawler\frontend\commands;

use Yii;
use luya\console\Command;
use luya\crawler\models\Searchdata;
use yii\console\Exception;

/**
 * Send E-Mail of search statistic for last 7 days.
 *
 * Console command use:
 *
 * ```sh
 * ./vendor/bin/luya crawler/statistic
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
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
        
        $html = '<h1>Search analytics from '. date("d.m.Y", $lastWeek) . ' until '.date("d.m.Y", time()).'</h1>';
        $html.= '<p>Page: ' . Yii::$app->siteTitle.'</p>';
        $html.= '<p>Number of searches: <strong>'.count($results).'</strong></p>';
        
        if (!empty($data['noresults'])) {
            $html.= '<p>Querys <b>without</b> results:</p>';
            $html.= '<table border="1" cellpadding="4" cellspacing="0"><tr><td>Query</td><td>Language</td><td>Date</td></tr>';
            foreach ($data['noresults'] as $item) {
                $html.= '<tr><td>'.$item['query'].'</td><td>'.$item['language'].'</td><td>'. date("d.m.Y", $item['timestamp']).'</td></tr>';
            }
            $html.='</table>';
        }
        
        if (!empty($data['results'])) {
            $html.= '<p>Querys <b>with</b> results:</p>';
            $html.= '<table border="1" cellpadding="4" cellspacing="0"><tr><td>Query</td><td>Results</td><td>Language</td><td>Date</td></tr>';
            foreach ($data['results'] as $item) {
                $html.= '<tr><td>'.$item['query'].'</td><td>'.$item['results'].'</td><td>'.$item['language'].'</td><td>'. date("d.m.Y", $item['timestamp']).'</td></tr>';
            }
            $html.='</table>';
        }
        
        Yii::$app->mail->compose('[' . Yii::$app->siteTitle.'] Search analytics from '. date("d.m.Y", $lastWeek) . ' until '.date("d.m.Y", time()), $html)->addresses($this->module->statisticRecipients)->send();
        
        return $this->outputSuccess('Search analytics mail sent');
    }
}
