<?php


namespace console\controllers;


use backend\models\Qar;
use common\helpers\QarNotificationHelper;
use yii\console\Controller;

class NotificationController extends Controller
{
    /**
     *
     */
    public function actionReminders(){
        print "Sending reminders \n";
        $this->findQarForReminders();
    }

    public function actionAlerts(){
        print "Sending alerts \n";
        $this->findOverdueQars();
    }

    /**
     * Find overdue qar that were not completed or canceled
     */
    private function findOverdueQars(){
        $qars = Qar::find()
            ->where(["<", "deadline", date("Y-m-d", strtotime("now"))])
            ->andWhere(["<>", "status", Qar::STATUS_COMPLETED])
            ->andWhere(["<>", "status", Qar::STATUS_CANCELED])->asArray()->all();
        print "Sending overdue alerts for " .count($qars) . " QARS \n";

        foreach ($qars as $qar){
            (new QarNotificationHelper())->constructQarConsoleAlertNotification($qar);
        }
    }

    /**
     * preferably to be run
     * Find overdue qar that were notYii::t('notification','completed')or canceled
     */
    private function findQarForReminders(){

        $reminderPeriodStart = date("Y-m-d H:i:s", strtotime("now"));
        $reminderPeriodEnd = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime("now")));

        print "sending reminders between ". $reminderPeriodStart . " and ". $reminderPeriodEnd . "\n";

        $qars = Qar::find()
            ->where( ["or",
                ["between", "reminder1", $reminderPeriodStart, $reminderPeriodEnd],
                ["between", "reminder2", $reminderPeriodStart, $reminderPeriodEnd]
            ])
            ->andWhere(["<>", "status", Qar::STATUS_COMPLETED])
            ->andWhere(["<>", "status", Qar::STATUS_CANCELED])->asArray()->all();

        print "Sending deadline reminder for " .count($qars) . " QARS \n";

        foreach ($qars as $qar){
            (new QarNotificationHelper())->constructQarConsoleReminderNotification($qar);
        }
    }
}