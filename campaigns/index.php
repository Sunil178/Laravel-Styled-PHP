<?php
    ob_start();

    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."database".DIRECTORY_SEPARATOR."model.php";

    $model = new Model('campaigns');
    $campaigns = $model->getAll();
?>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr class="text-nowrap">
                    <th> # </th>
                    <th> Name </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($campaigns as $index => $campaign) { ?>
                    <tr>
                        <td> <?php echo ($index + 1) ?> </td>
                        <td> <?php echo $campaign->name ?> </td>
                        <td>
                            <a href="../campaigns/edit.php?campaign_id=<?php echo $campaign->id ?>" class="btn btn-info btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php
    $customSection = ob_get_clean();

    include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."index.php";
?>
