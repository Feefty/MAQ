<?php
require_once 'autoload.php';
if ($Util->getRole() != 'admin')
    die('Not allowed!');

$title = 'Create a Room';
?>
<?php require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Create a Room</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/rooms.php">Rooms</a></li>
                        <li class="active">Create a Room</li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/rooms/room_create.php" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="active" checked> Active
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="inactive"> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="room_create" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Create</button> <a href="<?= $config['base'] ?>/rooms.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>

<?php require_once 'footer.php' ?>
