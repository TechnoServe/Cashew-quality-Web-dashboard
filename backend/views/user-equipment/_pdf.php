<!DOCTYPE html>
<html>

<body>
    <div class="panel-body">
        <h3>List of User Equipments</h3>
        <table class="table-bordered">
            <tr>
                <th>User</th>
                <th>Company</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Name</th>
                <th>Manufacturing Date</th>
                <th>Created At</th>
            </tr>
            <?php

            use backend\models\Company;
            use backend\models\User;
            use yii\helpers\Html;

            $no = 1;
            foreach ($dataProvider->getModels() as $row) {
            ?>
                <tr>
                    <td><?= $row['id_user'] ? User::findOne($row['id_user'])->getFullName() : '' ?></td>
                    <td><?= $row['company_id'] ? Company::findOne($row['company_id'])->name : '' ?></td>
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
</body>

</html>