<?php
require_once 'autoload.php';
$title = 'Registration Codes';

$registrationCodes = $DB->fetchAll('SELECT tbl_registration_codes.*, tbl_sections.fld_name as fld_section FROM tbl_registration_codes
                                    LEFT JOIN tbl_sections ON tbl_sections.fld_section_id = tbl_registration_codes.fld_section_id');
require_once 'header.php' ?>

        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Registration Code</h1>
                    <ol class="breadcrumb">
                        <li class="active">Registration Code</li>
                        <li><a href="<?= $config['base'] ?>/registration_code_create.php">Create a Registration Code</a></li>
                    </ol>
                    <table data-toggle="table" data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Role</th>
                                <th>Section</th>
                                <th>Status</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrationCodes as $registrationCode): ?>
                                <tr>
                                    <td><?= $registrationCode['fld_code'] ?></td>
                                    <td><?= $registrationCode['fld_role'] ?></td>
                                    <td><?= $registrationCode['fld_section'] ?></td>
                                    <td><?= $registrationCode['fld_status'] ? 'Active' : 'Inactive' ?></td>
                                    <td><?= $registrationCode['fld_date_created'] ?></td>
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
