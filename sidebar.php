<ul class="nav nav-pills nav-stacked sidebar" style="font-size:21px;">
    <?php if ($Util->getRole() == 'admin' || $Util->getRole() == 'teacher'): ?>
        <li role="presentation"><a href="<?= $config['base'] ?>/quizzes.php"><i class="fa fa-chevron-right fa-fw"></i> Quizzes</a></li>
    <?php endif ?>
    <?php if ($Util->getRole() == 'admin'): ?>
        <li role="presentation"><a href="<?= $config['base'] ?>/sections.php"><i class="fa fa-chevron-right fa-fw"></i> Sections</a></li>
        <li role="presentation"><a href="<?= $config['base'] ?>/subjects.php"><i class="fa fa-chevron-right fa-fw"></i> Subjects</a></li>
        <li role="presentation"><a href="<?= $config['base'] ?>/rooms.php"><i class="fa fa-chevron-right fa-fw"></i> Rooms</a></li>
    <?php else: ?>
        <li role="presentation"><a href="<?= $config['base'] ?>/section_view.php"><i class="fa fa-chevron-right fa-fw"></i> View Section</a></li>
    <?php endif ?>
</ul>
