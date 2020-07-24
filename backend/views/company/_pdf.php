<!DOCTYPE html>
<html>

<head>
    <title>Companies</title>
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
        <h1>List of Companies</h1>
        <table border="0">
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Address</th>
                <th>Primary Contact</th>
                <th>Primary Phone</th>
                <th>Priamry Email</th>
                <th>Fax Number</th>
                <th>Status</th>
                <th>Description</th>
                <th>Created At</th>
            </tr>
            <?php

            use backend\models\Company;

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