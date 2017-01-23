<?php require_once 'autoload.php' ?>
<?php require_once 'header.php' ?>
<div class="container content">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="<?= $config['base'] ?>/actions/login.php" method="post">
                        <h2>Login</h2>
                        <?= $Util->printMessage() ?>
                        <?= $Util->printError() ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button type="submit" name="login" class="btn btn-primary">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>
