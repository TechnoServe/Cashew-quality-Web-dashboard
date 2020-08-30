<?php


namespace common\helpers;


use backend\models\Site;
use Yii;

class QarNotificationHelper
{

    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarCreationNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR" . $model->id . " has been created",
            'body' => Yii::t("app","Qar number {number} has been created. it will be on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarUpdateNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR" . $model->id . " has been updated",
            'body' => Yii::t("app","Qar number {number} has been updated. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
        ]));
    }
}