<?php
require_once 'autoload.php';

$Util->loginRequired();

$notifs = $DB->fetchAll('SELECT * FROM tbl_notifications WHERE fld_user_id = ?', [$_SESSION['fld_user_id']]);
$title = 'Notifications';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Notifications</h1>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <table data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Notifications</th>
                                <th>Received</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifs as $notif): ?>
                                <tr<?= $notif['fld_read'] == 0 ? ' class="info"' : '' ?>>
                                    <td><a href="<?= $config['base'] ?>/notification_view.php?id=<?= $notif['fld_notification_id'] ?>"><?= $notif['fld_subject'] ?></a></td>
                                    <td><?= date('F j, Y g:ia', strtotime($notif['fld_date_created'])) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
