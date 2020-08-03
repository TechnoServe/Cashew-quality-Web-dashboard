<?php
use backend\models\Company;
use backend\models\User;
?>

<?= $this->render("../shared/_pdf_list_header", ["title"=>Yii::t("app", "List of users")])?>

<div class="panel-body">
        <table class="table-bordered">
            <tr>
                <th><?=Yii::t("app", "Username")?></th>
                <th><?=Yii::t("app", "Name")?></th>
                <th><?=Yii::t("app", "Email")?></th>
                <th><?=Yii::t("app", "Phone")?></th>
                <th><?=Yii::t("app", "Address")?></th>
                <th><?=Yii::t("app", "Role")?></th>
                <th><?=Yii::t("app", "Status")?></th>
                <th><?=Yii::t("app", "Created At")?></th>
            </tr>
            <?php
            $no = 1;
            foreach ($models as $row) {?>
                <tr>
                    <?php if($showCompany): ?>
                        <td><?= $row['username'] ?> <br>  <?= $row['company_id'] ? '<strong>'. Company::findOne($row['company_id'])->name .'</strong>' : '' ?></td>
                    <?php  else: ?>
                        <td><?= $row['username'] ?></td>
                    <?php  endif; ?>
                    <td><?= $row['id'] ? User::findOne($row['id'])->getFullName() : '' ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['role'] ? User::getUserRoleByIndex($row['role']) : '' ?></td>
                    <td><?= $row['status'] ? User::getUserStatusByIndex($row['status']) : '' ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>