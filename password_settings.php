<?php
require_once 'autoload.php';
$Util->loginRequired();
?>
<?php require_once 'header.php' ?>

        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Password Settings</h1>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <form action="<?= $config['base'] ?>/actions/passwords/password_settings.php" method="post">
                        <input type="hidden" name="user_id" value="<?= $_SESSION['fld_user_id'] ?>">
                        <div class="form-group">
                            <label for="password">Current Password*</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="npassword">New Password*</label>
                            <input type="password" name="npassword" id="npassword" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="repassword">Re-enter New Password*</label>
                            <input type="password" name="renpassword" id="renpassword" class="form-control" required>
                        </div>
                        <button type="submit" name="password_settings" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>

<?php require_once 'footer.php' ?>
