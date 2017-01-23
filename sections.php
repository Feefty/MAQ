<?php
require_once 'autoload.php';

if ($Util->getRole() != 'admin')
    die('Not allowed!');

if (Input::has('action') && Input::has('id') && Input::get('action') == 'delete') {
    $sectionId = (int) Input::get('id');
    $stmt = $DB->query('DELETE FROM tbl_sections WHERE fld_section_id = ?')->getStatement();
    $stmt->execute([$sectionId]);
    $Util->setMessage('Section deleted!');
    $Util->redirect('sections.php');
}

$sections = $DB->fetchAll('SELECT tbl_sections.*, COUNT(tbl_section_students.fld_section_id) as fld_total_students FROM tbl_sections
                        LEFT JOIN tbl_section_students ON tbl_section_students.fld_section_id = tbl_sections.fld_section_id');
$title = 'Sections';
require_once 'header.php';
?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Sections</h1>
                    <ol class="breadcrumb">
                        <li class="active">Sections</li>
                        <li><a href="<?= $config['base'] ?>/section_create.php">Create a Section</a></li>
                    </ol>
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                    <table data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Year</th>
                                <th>Course</th>
                                <th>Total Students</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections as $section): ?>
                                <tr>
                                    <td><a href="<?= $config['base'] ?>/section_view.php?id=<?= $section['fld_section_id'] ?>"><?= $section['fld_name'] ?></a></td>
                                    <td><?= $section['fld_year_level'] ?></td>
                                    <td><?= $section['fld_course'] ?></td>
                                    <td><?= number_format($section['fld_total_students']) ?></td>
                                    <td><a href="<?= $config['base'] ?>/section_edit.php?id=<?= $section['fld_section_id'] ?>"><i class="fa fa-pencil fa-fw"></i></a></td>
                                    <td><a href="<?= $config['base'] ?>/sections.php?id=<?= $section['fld_section_id'] ?>&action=delete"><i class="fa fa-times fa-fw"></i></a></td>
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
