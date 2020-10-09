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
            'title_en' => "QAR#" . $model->id . " has been created",
            'title_fr' => "QAR#" . $model->id . " a été créé",
            'title_pt' => "QAR#" . $model->id . " foi criado",
            'body_en' => sprintf("QAR#%d has been created. it will be on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d a été créé. il sera sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi criado. será no site %s, e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarUpdateNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been updated",
            'title_fr' => "QAR#" . $model->id . " a été mis à jour",
            'title_pt' => "QAR#" . $model->id . " tem sido atualizado",
            'body_en' => sprintf("QAR#%d has been updated. it is on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d a été mis à jour. il est sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi atualizado. está no site  %s, e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarCancelNotification($model)
    {
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been canceled",
            'title_fr' => "QAR#" . $model->id . " a été annulé",
            'title_pt' => "QAR#" . $model->id . " foi cancelado",
            'body_en' => sprintf("QAR#%d has been canceled. it was on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d a été annulé. il était sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi cancelado. estava no site %s e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));

    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarRestoreNotification($model){

        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been restored",
            'title_fr' => "QAR#" . $model->id . " a été restauré",
            'title_pt' => "QAR#" . $model->id . " foi restaurado",
            'body_en' => sprintf("QAR#%d has been canceled. it was on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d qui a été annulé a été restauré. il est sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d que foi cancelado foi restaurado. está no site %s e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarDeleteNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been deleted",
            'title_fr' => "QAR#" . $model->id . " a été supprimé",
            'title_pt' => "QAR#" . $model->id . " foi deletado",
            'body_en' => sprintf("QAR#%d  has been deleted. it was on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d a été supprimé. il était sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi excluído. estava no site %s e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructAPIQarCreateNotification($model){
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been created",
            'title_fr' => "QAR#" . $model->id . " a été créé",
            'title_pt' => "QAR#" . $model->id . " foi criado",
            'body_en' => sprintf("QAR#%d has been created. it will be on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d a été créé. il sera sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi criado. será no site %s, e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }



    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructAPIQarCreateDetailNotification($model){
        $model = Qar::findOne($model->id_qar);
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been updated",
            'title_fr' => "QAR#" . $model->id . " a été mis à jour",
            'title_pt' => "QAR#" . $model->id . " tem sido atualizado",
            'body_en' => sprintf("QAR#%d has been updated. it is on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d a été mis à jour. il est sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi atualizado. está no site  %s, e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }



    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructAPIQarCreateResultNotification($model){
        $model = Qar::findOne($model->id_qar);
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $model->id . " has been completed",
            'title_fr' => "QAR#" . $model->id . " a été complété",
            'title_pt' => "QAR#" . $model->id . " foi completado",
            'body_en' => sprintf("QAR#%d has been completed. it is on site %s, and it is due on %s", $model->id, $model->site_name, $model->deadline),
            'body_fr' => sprintf("QAR#%d est terminé. il est sur le site %s, et il est dû le %s", $model->id, $model->site_name, $model->deadline),
            'body_pt' => sprintf("QAR#%d foi concluído. está no site %s e é devido em %s", $model->id, $model->site_name, $model->deadline),
            'recipients' => [$model->buyer, $model->field_tech],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }



    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarConsoleReminderNotification($qar){
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $qar["id"] . " is due soon",
            'title_fr' => "QAR#" . $qar["id"] . " est due bientôt",
            'title_pt' => "QAR#" . $qar["id"] . " é devido em breve",
            'body_en' => sprintf("QAR#%d is close to its deadline. it is on site %s, and it is due on %s", $qar["id"], $qar["site_name"], $qar["deadline"]),
            'body_fr' => sprintf("QAR#%d est proche de sa date limite. il est sur le site %s, et il est dû le %s", $qar["id"], $qar["site_name"], $qar["deadline"]),
            'body_pt' => sprintf("QAR#%d está perto de seu prazo. está no site %s, e é devido em %s", $qar["id"], $qar["site_name"], $qar["deadline"]),
            'recipients' => [$qar["buyer"], $qar["field_tech"]],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }


    /**
     * Construct qar common notification and add to queue
     * @param $model
     */
    public function constructQarConsoleAlertNotification($qar){
        Yii::$app->queue->push(new NotificationHelper([
            'title_en' => "QAR#" . $qar["id"] . " is overdue",
            'title_fr' => "QAR#" . $qar["id"] . " est en retard",
            'title_pt' => "QAR#" . $qar["id"] . " está atrasado",
            'body_en' => sprintf("QAR#%d passed it's deadline. it is on site %s, and it is due on %s", $qar["id"], $qar["site_name"], $qar["deadline"]),
            'body_fr' => sprintf("QAR#%d a dépassé sa date limite. il est sur le site %s, et il était dû le %s", $qar["id"], $qar["site_name"], $qar["deadline"]),
            'body_pt' => sprintf("QAR#%d também ultrapassou o prazo. estava no site %s, e era devido em %s", $qar["id"], $qar["site_name"], $qar["deadline"]),
            'recipients' => [$qar["buyer"], $qar["field_tech"]],
            'destinations' => [NotificationHelper::DESTINATION_EMAIL, NotificationHelper::DESTINATION_APP]
        ]));
    }
}