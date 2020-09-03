<?php


namespace console\controllers;


use backend\models\Qar;
use yii\console\Controller;

class NotificationController extends Controller
{
    /**
     *
     */
    public function actionIndex(){
        print "Controller for sending notifications \n";
        $this->findOverdueQars();

        var_dump($this->calculateNotificationTimeForQar("2020-08-20 11:18:36", "2020-08-20 11:30:36"));
    }

    /**
     * Find overdue qar that were not completed or canceled
     */
    private function findOverdueQars(){
        $qars = Qar::find()
            ->where(["<", "deadline", date("Y-m-d", strtotime("now"))])
            ->andWhere(["<>", "status", Qar::STATUS_COMPLETED])
            ->andWhere(["<>", "status", Qar::STATUS_CANCELED])->asArray()->all();
        print count($qars) . "\n";
    }

    /**
     * preferably to be run
     * Find overdue qar that were notYii::t('notification','completed')or canceled
     */
    private function findQarsEndingToday(){
        $qars = Qar::find()
            ->where(["deadline" => date("Y-m-d", strtotime("now"))])
            ->andWhere(["<>", "status", Qar::STATUS_COMPLETED])
            ->andWhere(["<>", "status", Qar::STATUS_CANCELED])->asArray()->all();
        print count($qars) . "\n";
    }
}