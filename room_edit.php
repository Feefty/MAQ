<?php
require_once 'autoload.php';
$title = 'Room Edit';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

if (Input::has('id')) {
    $roomId = (int) Input::get('id');
} else {
    die('Not found!');
}

$room = $DB->fetch('SELECT * FROM tbl_rooms WHERE fld_room_id = ?', [$roomId]);
require_once 'header.php' ?>
<div class="container content">
    <div class="row">
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Room Edit</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/rooms.php">Rooms</a></li>
                        <li><a href="<?= $config['base'] ?>/room_create.php">Create a Room</a></li>
                        <li class="active">Room Edit</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/rooms/room_edit.php" method="post">
                        <input type="hidden" name="room_id" value="<?= $room['fld_room_id'] ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="name" id="name" class="form-control" required value="<?= $room['fld_name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if ($room['fld_status'] == 'active'): ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="active" checked> Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="inactive"> Inactive
                                        </label>
                                    <?php else: ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="active"> Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="inactive" checked> Inactive
                                        </label>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="room_edit" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Save</button> <a href="<?= $config['base'] ?>/rooms.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>
