<!DOCTYPE html>
<html>

<body>
    <div class="panel-body">
        <h3>List of Users</h3>
        <table class="table-bordered">
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Preferred Language</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
            <?php

            use backend\models\Company;
            use backend\models\User;

            $no = 1;
            foreach ($dataProvider->getModels() as $row) {
            ?>
                <tr>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['first_name'] ?></td>
                    <td><?= $row['middle_name'] ?></td>
                    <td><?= $row['last_name'] ?></td>
                    <td><?= $row['company_id'] ? Company::findOne($row['company_id'])->name : '' ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['language'] ? User::getLanguageByIndex($row['language']) : '' ?></td>
                    <td><?= $row['role'] ? User::getUserRoleByIndex($row['role']) : '' ?></td>
                    <td><?= $row['status'] ? User::getUserStatusByIndex($row['status']) : '' ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>

</html>