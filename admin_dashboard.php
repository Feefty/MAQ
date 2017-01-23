<?php require_once 'autoload.php';
require_once 'header.php' ?>
    <?= $Util->printMessage() ?>
    <?= $Util->printError() ?>

        <h1>Welcome <?= $_SESSION['fld_username'] ?> </h1>
            <pre>Username: <b><?= $_SESSION['fld_username'] ?></b>
            <p>Role: <b><?= $_SESSION['fld_role'] ?></b>
            <p>Time Logged in: <b><?= $_SESSION['fld_last_login'] ?></b>
            <p>Status: <b>Active</b>
            </pre>

                <div class="col-sm-12" style="padding-top:10px;">

                    <div class="col-sm-4">
                        <a href="<?= $config['base'] ?>/quiz_create.php"><button class="btn btn-success btn-lg" style="margin-top:10px; min-height: 200px;width:100%; font-size:22px;"><i class="fa fa-pencil-square-o fa-fw" style="color:#ffff66;"></i> Create Quiz</button></a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?= $config['base'] ?>/quizzes.php"><button class="btn btn-primary btn-lg" style="margin-top:10px; min-height: 95px;width:100%; font-size:22px;"><i class="fa fa-th-list fa-fw" style="color:#ffff66;"></i> Manage Quiz</button></a>
                        <a href="<?= $config['base'] ?>/sections.php"><button class="btn btn-warning btn-lg" style="margin-top:10px; min-height: 95px;width:100%; font-size:22px;"><i class="fa fa-user fa-fw" style="color:#ffff66;"></i> Manage Sections</button></a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?= $config['base'] ?>/subjects.php"><button class="btn btn-info btn-lg" style="margin-top:10px; min-height: 95px;width:100%; font-size:22px;"><i class="fa fa-book fa-fw" style="color:#ffff66;"></i> Manage Subjects</button></a>

                        <a href="<?= $config['base'] ?>/rooms.php"><button class="btn btn-danger btn-lg" style="margin-top:10px; min-height: 95px;width:100%; font-size:22px;"><i class="fa fa-users fa-fw" style="color:#ffff66;"></i> Manage Rooms</button></a>
                    </div>

                </div>
                 


<?php require_once 'footer.php' ?>
