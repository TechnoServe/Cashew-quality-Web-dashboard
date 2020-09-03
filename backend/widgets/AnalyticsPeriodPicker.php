<?php
namespace backend\widgets;


class AnalyticsPeriodPicker extends \yii\base\Widget
{
    public $url;
    public $startDate;
    public $endDate;
    public $predefinedPeriod;
    public $country_code;

    public function run()
    {
        return $this->render("analyticsPeriodPicker",[
            'startDate' =>$this->startDate,
            'endDate' =>$this->endDate,
            'predefinedPeriod' =>$this->predefinedPeriod,
            'country_code' =>$this->country_code,
            'url' =>$this->url,
        ]);
    }
}