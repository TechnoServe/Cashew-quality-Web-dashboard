<!DOCTYPE html>
<html>

<head>
    <title>Qars</title>
    <style>
        .page {
            padding: 2cm;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ccc;
        }

        table th {
            background-color: whitesmoke;
        }
    </style>
</head>

<body>
    <div class="page">
        <h1>List of Qars</h1>
        <table border="0">
            <tr>
                <th>Company</th>
                <th>Buyer</th>
                <th>Field Tech</th>
                <th>Farmer</th>
                <th>Initiator</th>
                <th>Site</th>
                <th>Estimated Volume of bags</th>
                <th>Estimated Volume of Stock (KG)</th>
                <th>Deadline</th>
                <th>Status</th>
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
                    <td><?= $row['company_id'] ? Company::findOne($row['company_id'])->name : '' ?></td>
                    <td><?= $row['buyer'] ? User::findOne($row['buyer'])->getFullName() : '' ?></td>
                    <td><?= $row['field_tech'] ? User::findOne($row['field_tech'])->getFullName() : '' ?></td>
                    <td><?= $row['farmer'] ? User::findOne($row['farmer'])->getFullName() : '' ?></td>
                    <td><?= $row['initiator'] ? Qar::getInitiatorByIndex($row['initiator']) : '' ?></td>
                    <td><?= $row['site'] ? Site::findOne($row['site'])->site_name : '' ?></td>
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
</body>

</html>