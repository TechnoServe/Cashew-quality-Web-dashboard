<!DOCTYPE html>
<html>

<body>
    <div class="panel-body">
        <h3>List of Sites</h3>
        <table class="table-bordered">
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