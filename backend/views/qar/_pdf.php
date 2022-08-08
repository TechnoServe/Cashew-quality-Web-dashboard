<?= $this->render("../shared/_pdf_list_header", ["title" => Yii::t("app", "List of Qars")]) ?>

<div class="panel-body">
    <table class="table-bordered">
        <tr>
            <?php if ($showCompany) : ?>
                <th><?= Yii::t("app", "Company") ?></th>
            <?php endif; ?>
            <th><?= Yii::t("app", "Buyer") ?></th>
            <th><?= Yii::t("app", "Field Tech") ?></th>
            <th><?= Yii::t("app", "Initiator") ?></th>
            <th><?= Yii::t("app", "Site Name") ?></th>
            <th><?= Yii::t("app", "Site Location") ?></th>
            <th><?= Yii::t("app", "Estimated number of bags") ?></th>
            <th><?= Yii::t("app", "Estimated Volume of Stock (KG)") ?></th>
            <th><?= Yii::t("app", "Deadline") ?></th>
            <th><?= Yii::t("app", "Status") ?></th>
            <th><?= Yii::t("app", "Created At") ?></th>
        </tr>
        <?php

        use backend\models\Company;
        use backend\models\Qar;
        use backend\models\Site;
        use backend\models\User;

        $no = 1;
        foreach ($models as $row) {
        ?>
            <tr>
                <?php if ($showCompany) : ?>
                    <td><?= $row['company_id'] ? Company::findOne($row['company_id'])->name : '' ?></td>
                <?php endif; ?>
                <td><?= $row['buyer'] ? User::findOne($row['buyer'])->getFullName() : '' ?></td>
                <td><?= $row['field_tech'] ? User::findOne($row['field_tech'])->getFullName() : '' ?></td>
                <td><?= $row['initiator'] ? Qar::getInitiatorByIndex($row['initiator']) : '' ?></td>
                <td><?= $row['site_name'] ?></td>
                <td><?= $row['site_location'] ?></td>
                <td><?= $row['number_of_bags'] ?></td>
                <td><?= $row['volume_of_stock'] ?></td>
                <td><?= $row['deadline'] ?></td>
                <td><?= $row['status'] ? User::getUserStatusByIndex($row['status']) : '' ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>