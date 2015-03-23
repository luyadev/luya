<?php

\yii::$app->luya->auth->addApi('api-admin-user', 'Benutzer');
\yii::$app->luya->auth->addApi('api-admin-group', 'Gruppen');
\yii::$app->luya->auth->addApi('api-admin-lang', 'Sprachen');
\yii::$app->luya->auth->addApi('api-admin-effect', 'Bild Effekte');
\yii::$app->luya->auth->addApi('api-admin-filter', 'Bild Filter');