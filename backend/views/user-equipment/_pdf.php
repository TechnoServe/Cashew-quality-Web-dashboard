<?= $this->render("../shared/_pdf_list_header", ["title"=>Yii::t("app", "User Equipments")])?>

<div class="panel-body">
    <table class="table-bordered">
        <tr>
            <th><?=Yii::t("app", "User")?></th>
            <th><?=Yii::t("app", "Brand")?></th>
            <th><?=Yii::t("app", "Model")?></th>
            <th><?=Yii::t("app", "Name")?></th>
            <th><?=Yii::t("app", "Manufacturing date")?></th>
            <th><?=Yii::t("app", "Created At")?></th>
        </tr>
        <?php
        use backend\models\Company;
        use backend\models\User;
        $no = 1;
        foreach ($models as $row) {
        ?>
            <tr>
                <?php if($showCompany): ?>
                    <td><?= $row['id_user'] ? User::findOne($row['id_user'])->getFullName() : '' ?> <br>  <?= $row['company_id'] ? '<strong>'. Company::findOne($row['company_id'])->name .'</strong>' : '' ?></td>
                <?php  else: ?>
                    <td><?= $row['id_user'] ? User::findOne($row['id_user'])->getFullName() : '' ?></td>
                <?php  endif; ?>
                <td><?= $row['brand'] ?></td>
                <td><?= $row['model'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['manufacturing_date'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>