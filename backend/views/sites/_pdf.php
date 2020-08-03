<?= $this->render("../shared/_pdf_list_header", ["title"=>Yii::t("app", "List of Sites")])?>

<div class="panel-body">
        <table class="table-bordered">
            <tr>
                <?php if($showCompany): ?>
                <th><?=Yii::t("app", "Company")?></th>
                <?php  endif; ?>
                <th><?=Yii::t("app", "Site name")?></th>
                <th><?=Yii::t("app", "Site location")?></th>
                <th><?=Yii::t("app", "Map cordinates")?></th>
                <th><?=Yii::t("app", "Created At")?></th>
            </tr>
            <?php
            use backend\models\Company;
            $no = 1;
            foreach ($dataProvider->getModels() as $row) {
            ?>
                <tr>
                    <?php if($showCompany): ?>
                    <td><?= $row['company_id'] ? Company::findOne($row['company_id'])->name : '' ?></td>
                    <?php  endif; ?>
                    <td><?= $row['site_name'] ?></td>
                    <td><?= $row['site_location'] ?></td>
                    <td><?= $row['map_location'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>