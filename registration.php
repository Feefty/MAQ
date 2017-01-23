<?php
require_once 'autoload.php';
$title = 'Registration';
?>
<?php require_once 'header.php' ?>
    <?= $Util->printMessage() ?>
    <?= $Util->printError() ?>
    <div class="col-sm-8">
        <h2>New to Make A Quiz? <pre>Register an Account.</pre></h2>
    </div>
            <div class="col-sm-4">
                <h5>Tips on how to create a strong password</h5>
            <ul style="font-size:11px;">
                <li>More than 10 characters</li>
                <li>Special characters (ex. !@#$%^&*())</li>
                <li>Numbers</li>
                <li>User random case. Upper case or lower case (ex. tReE)</li>
            </ul>
        </div>
            <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form id="registration" action="<?= $config['base'] ?>/actions/registration.php" method="post">
                        <div class="form-group">
                            <label for="username">Username*</label>
                            <input type="text" name="username" id="username" class="form-control" required placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="repassword">Re-enter Password*</label>
                            <input type="password" name="repassword" id="repassword" class="form-control" required placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <label for="role">Role*</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="role" value="student" required checked>
                                        Student
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="role" value="teacher" required>
                                        Teacher
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code">Registration Code*</label>
                            <input type="password" name="code" id="code" class="form-control" required placeholder="Registration Code">
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="first_name">First Name*</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" required placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name*</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" required placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <label for="middle_name">Middle Name*</label>
                                    <input type="text" name="middle_name" id="middle_name" class="form-control" required placeholder="Middle Name">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender*</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="male" required checked>
                                                Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="female" required>
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" style="resize:none;" placeholder="# Street Name, Barangay, City, Province"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <h5>Students, Please complete this section.</h5>
                                <hr>
                                <div class="student-fields">
                                    <div class="form-group">
                                        <label for="student_id">Student ID*</label>
                                        <input type="text" name="student_id" id="student_id" class="form-control" placeholder="Student ID (if Student)">
                                    </div>
                                    <div class="form-group">
                                        <label for="student_id">Year Level*</label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="radio-inline">
                                                    <input type="radio" name="year_level" value="1" checked>
                                                    First Year
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="year_level" value="2">
                                                    Second Year
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="course">Course*</label>
                                        <select class="form-control" name="course" id="course">
                                            <?php foreach ($config['courses'] as $course): ?>
                                                <option value="<?= $course ?>"><?= $course ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="contact_no">Contact No.</label>
                                    <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="09XX-XXX-XXXX">
                                </div>
                                </div>
                        <button type="submit" name="registration" class="btn btn-primary">Create</button> <a href="<?= $config['base'] ?>/index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div><h5>By Clicking the "CREATE" button, You Agree with the <a href="#">Terms of Use of Make A Quiz.</a></h5>
        </div> 
<?php require_once 'footer.php' ?>
