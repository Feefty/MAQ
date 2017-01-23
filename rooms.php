<?php
require_once 'autoload.php';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

if (Input::has('action') && Input::has('id') && Input::get('action') == 'delete') {
    $roomId = (int) Input::get('id');
    $stmt = $DB->query('DELETE FROM tbl_rooms WHERE fld_room_id = ?')->getStatement();
    $stmt->execute([$roomId]);
    $Util->setMessage('Room deleted!');
    $Util->redirect('rooms.php');
}

$rooms = $DB->fetchAll('SELECT * FROM tbl_rooms');
$title = 'Rooms';
require_once 'header.php';
?>
<div class="container content">
    <div class="row">
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Rooms</h1>
                    <ol class="breadcrumb">
                        <li class="active">Rooms</li>
                        <li><a href="<?= $config['base'] ?>/room_create.php">Create a Room</a></li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <table data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room): ?>
                                <tr>
                                    <td><?= $room['fld_name'] ?></td>
                                    <td><?= ucfirst($room['fld_status']) ?></td>
                                    <td><a href="<?= $config['base'] ?>/room_edit.php?id=<?= $room['fld_room_id'] ?>"><i class="fa fa-pencil fa-fw"></i></a></td>
                                    <td><a href="<?= $config['base'] ?>/rooms.php?id=<?= $room['fld_room_id'] ?>&action=delete"><i class="fa fa-times fa-fw"></i></a></td>
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
    </div>
</div>
<?php require_once 'footer.php' ?>
