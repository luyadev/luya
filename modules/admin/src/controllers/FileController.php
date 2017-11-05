<?php

namespace luya\admin\controllers;

use Yii;
use luya\admin\Module;
use luya\admin\models\StorageFile;
use luya\admin\events\FileDownloadEvent;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * File Download Controller
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class FileController extends \luya\web\Controller
{
    public function actionDownload($id, $hash, $fileName)
    {
        // find file in file query
        $fileData = Yii::$app->storage->findFile(['id' => $id, 'hash_name' => $hash, 'is_deleted' => false]);
        // proceed when file exists
        if ($fileData) {
            // get file source from storage system
            $fileSourcePath = $fileData->serverSource;
            // verify again against database to add counter
            $model = StorageFile::findOne($fileData->id);
            // proceed when model exists
            if ($model && file_exists($fileSourcePath) && is_readable($fileSourcePath)) {
                $event = new FileDownloadEvent(['file' => $fileData]);
                
                Yii::$app->trigger(Module::EVENT_BEFORE_FILE_DOWNLOAD, $event);
                
                if (!$event->isValid) {
                    throw new BadRequestHttpException('Unable to performe this request due to access restrictions');
                }
                
                // update the model count stats
                $count = $model->passthrough_file_stats + 1;
                $model->passthrough_file_stats = $count;
                $model->update(false);
                // return header informations
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($fileData->name).'"');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fileSourcePath));
                flush();
                readfile($fileSourcePath);
                exit;
            }
        }
        
        // throw not found http exception, will not trigger error api transfer.
        throw new NotFoundHttpException("Unable to find requested file.");
    }
}
