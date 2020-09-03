<?php


namespace common\helpers;


use backend\models\Site;
use common\models\Qar;
use Yii;

class QarNotificationHelper
{

    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarCreationNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id . " has been created",
            'body' => Yii::t("app","Qar number {number} has been created. it will be on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarUpdateNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id . " has been updated",
            'body' => Yii::t("app","Qar number {number} has been updated. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarCancelNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id . " has been canceled",
            'body' => Yii::t("app","Qar number {number} has been canceled. it was on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarRestoreNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id . " has been restored",
            'body' => Yii::t("app","Qar number {number} which was canceled has been restored. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarDeleteNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id . " has been deleted",
            'body' => Yii::t("app","Qar number {number} has been deleted. it was on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructAPIQarCreateNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id . " has been created",
            'body' => Yii::t("app","Qar number {number} has been created. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id,
                "site" => Site::findOne($model->site)->site_name,
                "duedate" => $model->deadline
            ]),
            'recipients' => [$model->buyer, $model->field_tech, $model->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }



    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructAPIQarCreateDetailNotification($model){

        $qar = Qar::findOne($model->id_qar);

        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id_qar . " has been updated",
            'body' => Yii::t("app","Qar number {number} has been updated to progress. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id_qar,
                "site" => Site::findOne($qar->site)->site_name,
                "duedate" => $qar->deadline
            ]),
            'recipients' => [$qar->buyer, $qar->field_tech, $qar->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }



    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructAPIQarCreateResultNotification($model){

        $qar = Qar::findOne($model->id_qar);

        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $model->id_qar . " has been completed",
            'body' => Yii::t("app","Qar number {number} has been completed. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $model->id_qar,
                "site" => Site::findOne($qar->site)->site_name,
                "duedate" => $qar->deadline
            ]),
            'recipients' => [$qar->buyer, $qar->field_tech, $qar->farmer],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }



    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarConsoleReminderNotification($qar){

        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $qar["id"] . " is due soon",
            'body' => Yii::t("app","Qar number {number} is close to its deadline. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $qar["id"],
                "site" => Site::findOne($qar["site"])->site_name,
                "duedate" => $qar["deadline"]
            ]),
            'recipients' => [$qar["buyer"], $qar["field_tech"], $qar["farmer"]],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarConsoleAlertNotification($qar){

        Yii::$app->queue->push(new NotificationHelper([
            'title' => "QAR#" . $qar["id"] . " is overdue",
            'body' => Yii::t("app","Qar number {number} has also passed it's deadline. it is on site {site}, and it is due on {duedate}", [
                "number" => "QAR". $qar["id"],
                "site" => Site::findOne($qar["site"])->site_name,
                "duedate" => $qar["deadline"]
            ]),
            'recipients' => [$qar["buyer"], $qar["field_tech"], $qar["farmer"]],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }
}