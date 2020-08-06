
<div id="demo-panel-w-alert" class="panel">
    <!--Panel heading-->
    <div class="panel-heading ">
        <h3 class="panel-title">
            <span class="text-1x text-muted text-bold text-italic"> <?=Yii::t("app", "QAR Result Report")?></span>
        </h3>
    </div>

    <div class="panel-body">
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row">
                    <form>
                        <div class="form-group">
                            <select class="form-control dropDown" style="width: 150px;">
                                <option value="one" id="this_week_chart">This Week Chart</option>
                                <option value="two" id="last_month_chart">This Month Chart</option>
                                <option value="three" id="quarterly_chart">Quarterly Chart</option>
                                <option value="four" id="this_year_chart">This Year Chart</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <?php echo $this->render('qar_this_week', [

            ]); ?>

            <?php echo $this->render('qar_this_month', [

            ]); ?>

            <?php echo $this->render('qar_quarterly', [

            ]); ?>

            <?php echo $this->render('qar_this_year', [

            ]); ?>
        </div>
    </div>
</div>


<?php
$script = "
$('.dropDown').change(function() {
    var value= $(this).val();
    if(value=='one') {
        $('.this-week').show();
        $('.this-month').hide();
        $('.quarterly').hide();
        $('.this-year').hide();
    }
    if(value=='two') {
        $('.this-week').hide();
        $('.this-month').show();
        $('.quarterly').hide();
        $('.this-year').hide();
    }
    if(value=='three') {
        $('.this-week').hide();
        $('.this-month').hide();
        $('.quarterly').show();
        $('.this-year').hide();
    }
    if(value=='four') {
        $('.this-week').hide();
        $('.this-month').hide();
        $('.quarterly').hide();
        $('.this-year').show();
    }
});";
$this->registerJs($script);
?>