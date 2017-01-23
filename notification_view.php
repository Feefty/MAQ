<?php
require_once 'autoload.php';

if (!Input::has('id'))
    die('Not found!');

$notif = $DB->fetch('SELECT * FROM tbl_notifications WHERE fld_notification_id = ?', [(int) Input::get('id')]);
if ($notif == null)
    die('Not found!');

if ($notif['fld_read'] == 0) {
    $DB->update('UPDATE tbl_notifications SET fld_read = 1 WHERE fld_notification_id = ?', [(int) Input::get('id')]);
}

$title = 'Notification View';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Notification View</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/notifications.php">Notifications</a></li>
                        <li class="active">Notification View</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <h2><?= $notif['fld_subject'] ?></h2>
                    <p class="small text-muted"><?= $notif['fld_date_created'] ?></p>
                    <p><?= nl2br($notif['fld_message']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>
        
<?php require_once 'footer.php' ?>
