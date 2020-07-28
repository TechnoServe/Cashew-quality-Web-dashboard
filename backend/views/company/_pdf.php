<!DOCTYPE html>
<html>

<body>
    <div class="panel-body">
        <h3>List of Companies</h3>
        <table class="table-bordered">
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Address</th>
                <th>Primary Contact</th>
                <th>Primary Phone</th>
                <th>Priamry Email</th>
                <th>Fax Number</th>
                <th>Status</th>
                <th>Top Admin Users</th>
                <th>Top Admin View Users</th>
                <th>Institution Admin Users</th>
                <th>Institution Admin View Users</th>
                <th>Field Tech Users</th>
                <th>Buyer Users</th>
                <th>Farmer Users</th>
                <th>Qars To be Done</th>
                <th>Qars In Progress</th>
                <th>Qars Completed</th>
                <th>Qars Canceled</th>
                <th>Sites</th>
                <th>Description</th>
                <th>Created At</th>
            </tr>
            <?php

            use backend\models\Company;
            use backend\models\Qar;
            use backend\models\Site;
            use backend\models\User;

            $no = 1;
            foreach ($dataProvider->getModels() as $row) {
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
                    <td><?= $row['id'] ? User::find()->andWhere(["company_id" => $row['id'], "role" => User::ROLE_FIELD_FARMER])->count() : '' ?></td>
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
</body>

</html>