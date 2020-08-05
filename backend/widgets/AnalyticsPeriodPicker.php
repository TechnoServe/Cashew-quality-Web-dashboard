<?php
namespace backend\widgets;


class AnalyticsPeriodPicker extends \yii\base\Widget
{
    public $url;
    public $startDate;
    public $endDate;
    public $predefinedPeriod;

    public function run()
    {
        return $this->render("analyticsPeriodPicker",[
            'startDate' =>$this->startDate,
            'endDate' =>$this->endDate,
            'predefinedPeriod' =>$this->predefinedPeriod,
            'url' =>$this->url,
        ]);
    }
}