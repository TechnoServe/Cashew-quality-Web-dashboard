<?= $this->render("../shared/_pdf_list_header", ["title"=>Yii::t("app", "List of Companies")])?>

<div class="panel-body">
    <table class="table-bordered">
        <tr>
            <th><?=Yii::t("app", "Name")?></th>
            <th><?=Yii::t("app", "City")?></th>
            <th><?=Yii::t("app", "Address")?></th>
            <th><?=Yii::t("app", "Primary contact")?></th>
            <th><?=Yii::t("app", "Primary phone")?></th>
            <th><?=Yii::t("app", "Primary Email")?></th>
            <th><?=Yii::t("app", "Fax number")?></th>
            <th><?=Yii::t("app", "Status")?></th>
            <th><?=Yii::t("app", "Top admin users")?></th>
            <th><?=Yii::t("app", "Top admin view users")?></th>
            <th><?=Yii::t("app", "Institution admin users")?></th>
            <th><?=Yii::t("app", "Institution admin view users")?></th>
            <th><?=Yii::t("app", "Field Tech")?></th>
            <th><?=Yii::t("app", "Buyer")?></th>
            <th><?=Yii::t("app", "Qars to be done")?></th>
            <th><?=Yii::t("app", "Qars in progress")?></th>
            <th><?=Yii::t("app", "Qars completed")?></th>
            <th><?=Yii::t("app", "Qars canceled")?></th>
            <th><?=Yii::t("app", "Sites")?></th>
            <th><?=Yii::t("app", "Description")?></th>
            <th><?=Yii::t("app", "Created At")?></th>
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
                <td><?= $row['name'] ?></td>
                <td><?= $row['city'] ?></td>
                <td><?= $row['address'] ?></td>
                <td><?= $row['primary_contact'] ?></td>
                <td><?= $row['primary_phone'] ?></td>
                <td><?= $row['primary_email'] ?></td>
                <td><?= $row['fax_number'] ?></td>
                <td><?= $row['status'] ? Company::getCompanyStatusByIndex($row['status']) : '' ?></td>
                <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_ADMIN])->count() : '' ?></td>
                <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_ADMIN_VIEW])->count() : '' ?></td>
                <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_INSTITUTION_ADMIN])->count() : '' ?></td>
                <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_INSTITUTION_ADMIN_VIEW])->count() : '' ?></td>
                <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_FIELD_TECH])->count() : '' ?></td>
                <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_FIELD_BUYER])->count() : '' ?></td>
                <td><?= $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status" => Qar::STATUS_TOBE_DONE])->count() : '' ?></td>
                <td><?= $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status" => Qar::STATUS_IN_PROGRESS])->count() : '' ?></td>
                <td><?= $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status" => Qar::STATUS_COMPLETED])->count() : '' ?></td>
                <td><?= $row['id'] ? Qar::find()->andWhere(["id" => $row['id'], "status" => Qar::STATUS_CANCELED])->count() : '' ?></td>
                <td><?= $row['id'] ? Site::find()->andWhere(["company_id" => $row['id']])->count() : '' ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>