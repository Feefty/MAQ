<?php
require_once 'autoload.php';
$title = 'Plain';
?>
<?php require_once 'header.php' ?>
<div class="container content">
    <div class="row">
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Plain</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $config['base'] ?>/active.php">Not Active</a></li>
                        <li class="active">Active</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php require_once 'sidebar.php' ?>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ?>
