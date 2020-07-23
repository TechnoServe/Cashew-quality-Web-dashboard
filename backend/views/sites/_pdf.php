<!DOCTYPE html>
<html>

<head>
    <title>Sites</title>
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
        <h1>List of Sites</h1>
        <table border="0">
            <tr>
                <th>Company</th>
                <th>Site Name</th>
                <th>Site Location</th>
                <th>Map Coordinates</th>
                <th>Created At</th>
            </tr>
            <?php

            use backend\models\Company;

            $no = 1;
            foreach ($dataProvider->getModels() as $row) {
            ?>
                <tr>
                    <td><?= $row['company_id'] ? Company::findOne($row['company_id'])->name : '' ?></td>
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
</body>

</html>