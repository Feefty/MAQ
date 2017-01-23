<?php
require_once 'autoload.php';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

if (Input::has('action') && Input::has('id') && Input::get('action') == 'delete') {
    $subjectId = (int) Input::get('id');
    $stmt = $DB->query('DELETE FROM tbl_subjects WHERE fld_subject_id = ?')->getStatement();
    $stmt->execute([$subjectId]);
    $Util->setMessage('Subject deleted!');
    $Util->redirect('subjects.php');
}

$subjects = $DB->fetchAll('SELECT * FROM tbl_subjects');
$title = 'Subjects';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Subjects</h1>
                    <ol class="breadcrumb">
                        <li class="active">Subjects</li>
                        <li><a href="<?= $config['base'] ?>/subject_create.php">Create a Subject</a></li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <table data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td><?= $subject['fld_name'] ?></td>
                                    <td><?= ucfirst($subject['fld_description']) ?></td>
                                    <td><a href="<?= $config['base'] ?>/subject_edit.php?id=<?= $subject['fld_subject_id'] ?>"><i class="fa fa-pencil fa-fw"></i></a></td>
                                    <td><a href="<?= $config['base'] ?>/subjects.php?id=<?= $subject['fld_subject_id'] ?>&action=delete"><i class="fa fa-times fa-fw"></i></a></td>
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

<?php require_once 'footer.php' ?>
