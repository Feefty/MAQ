<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=  (isset($title) ? $title .': ' : '') . $config['title'] ?></title>
        <link rel="stylesheet" href="<?= $config['base'] ?>/assets/css/bootswatch.min.css">
        <link rel="stylesheet" href="<?= $config['base'] ?>/node_modules/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= $config['base'] ?>/node_modules/bootstrap-table/dist/bootstrap-table.min.css">
        <link rel="stylesheet" href="<?= $config['base'] ?>/node_modules/bootstrap-select/dist/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="<?= $config['base'] ?>/node_modules/bootstrap-toggle/css/bootstrap-toggle.min.css">
        <link rel="stylesheet" href="<?= $config['base'] ?>/assets/css/app.css">
        <script src="<?= $config['base'] ?>/node_modules/jquery/dist/jquery.min.js"></script>

    </head>
    <body style="background: linear-gradient(to bottom right, #4dc3ff, #004d4d);">
        <div class="container header-navbar">
            <nav class="navbar navbar-inverse" style="background:#345; border-color: transparent; margin-bottom:-1px; border-radius:0px;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                        <?php if (!$Util->isLogged()): ?>
                            <a style="font-size:35px; margin-top:5px; font-style: arial;" class="navbar-brand" href="<?= $config['base'] ?>/index.php"> Make A Quiz:</a>
                        <ul class="nav navbar-nav" style="margin-top:17px; font-size:24px; color:white;">
                            <li>Online Quiz Maker for Senior High School</li>
                        </ul>
                        <?php else: ?>
                            <?php if ($Util->getRole() =='student'): ?>
                                <a style="font-size:35px; margin-top:5px; font-style: arial;" class="navbar-brand" href="<?= $config['base'] ?>/student_dashboard.php"> Make A Quiz</a>
                            <?php endif ?>
                            <?php if ($Util->getRole() =='teacher'): ?>
                                <a style="font-size:35px; margin-top:5px; font-style: arial;" class="navbar-brand" href="<?= $config['base'] ?>/teacher_dashboard.php"> Make A Quiz</a>
                            <?php endif ?>
                            <?php if ($Util->getRole() =='admin'): ?>
                                <a style="font-size:35px; margin-top:5px; font-style: arial;" class="navbar-brand" href="<?= $config['base'] ?>/admin_dashboard.php"> Make A Quiz</a>
                            <?php endif ?>
                        <?php endif ?>
                </div>
                <div class="collapse navbar-collapse" id="bs-navbar">
                    <ul class="nav navbar-nav" style="margin-top:2px; font-size:21px;">
                        <?php if ($Util->isLogged()): ?>
                            <?php if ($Util->getRole() =='teacher'): ?>
                                <li><a href="<?= $config['base'] ?>/launch.php"><i class="fa fa-rocket fa-fw"></i> Launch</a></li>
                                <li><a href="<?= $config['base'] ?>/reports.php">Reports</a></li>
                            <?php else: ?>
                                <li><a href="<?= $config['base'] ?>/reports_student.php">Reports</a></li>
                            <?php endif ?>
                            <?php if ($Util->getRole() != 'admin'): ?>
                                <li><a href="<?= $config['base'] ?>/section_view.php">View Section</a></li>
                            <?php endif ?>
                        <?php else: ?>
                        <?php endif ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" style="margin-top:2px; margin-right:1px; font-size:19px;">
                        <?php if (!$Util->isLogged()): ?>
                        <?php else: ?>
                            <li><a href="<?= $config['base'] ?>/notifications.php"><i class="fa fa-bell fa-fw"></i> <span id="notif_count"><?= $Util->getUnreadNotifCount($DB, $_SESSION['fld_user_id']) ?></span></a></li>
                            <li class="dropdown">
                                <a style="margin-top:1px; margin-right:1px; font-size:19px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['fld_username'] ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu"  style="font-size:19px;">
                                    <li><a href="<?= $config['base'] ?>/profile.php"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                                    <li><a href="<?= $config['base'] ?>/password_settings.php"><i class="fa fa-asterisk fa-fw"></i> Password Settings</a></li>
                                    <li><a href="<?= $config['base'] ?>/logout.php"><i class="fa fa-sign-out fa-fw"></i> Log out</a></li>
                                </ul>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </nav>
        </div>
<div class="container content">
    <div class="well" style="min-height:635px;">
        <div class="panel-body">
