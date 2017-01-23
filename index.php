<?php require_once 'autoload.php';
require_once 'header.php' ?>

    <?php if (!$Util->isLogged()): ?>
    <div class="col-sm-3" style="margin-top:-18px;">
        <div class="panel panel-default panel-body" style="background-color:#004d4d;">
            <form action="<?= $config['base'] ?>/actions/login.php" method="post" style="color:white; min-height:220px;">
                    <?= $Util->printMessage() ?>
                    <?= $Util->printError() ?>
                <label for="username">Username</label>
                <div class="form-group input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                </div>
                <label for="password">Password</label>
                <div class="form-group input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" name="login" class="btn btn-primary">Sign In</button>
            </form>
            <a href="#">Forgot Password?</a>
            <label for="registration" style="color:white;">Create an Account.</label>
            <a href="<?= $config['base'] ?>/registration.php" class="btn btn-warning">Sign Up</a>
            <br>
            
        </div>
    </div>
    <?php endif ?>

    <div class="col-sm-9" style="margin-top:-30px;">
        <h1>WELCOME TO MAKE A QUIZ!</h1>
        <table class="table text-center">
            <tr>
                <td style="width:25%"><i class="fa fa-cloud fa-5x"></i></td>
                <td style="width:25%"><i class="fa fa-pencil-square-o fa-5x"></i></td>
                <td style="width:25%"><i class="fa fa-floppy-o fa-5x"></i></td>
                <td style="width:25%"><i class="fa fa-upload fa-5x"></i></td>
            </tr>
            <tr>
                <td>Educators can create quizes online.</td>
                <td>Students can take the quizzes online and can check their score.</td>
                <td>The Students can review their finish quizes.</td>
                <td>Teachers can upload their quizzes.</td>
            </tr>
        </table>
    </div>
        <div class="col-sm-2">
            <div class="panel panel-primary" style="min-height:150px; border:none;">
                <div class="panel-heading" style="font-size:20px;">ABM</div>
                    <div class="panel-body" style="font-size:12px;">ACCOUNTANCY, BUSINESS AND MANAGEMENT</div>
            </div>
        </div>
        <div class="col-sm-2" style="margin-left:-23px;">
            <div class="panel panel-info" style="min-height:150px; border:none;">
                <div class="panel-heading" style="font-size:20px;">GAS</div>
                    <div class="panel-body" style="font-size:12px; border:none;">GENERAL ACADEMIC STRANDS</div>
            </div>
        </div>
        <div class="col-sm-2" style="margin-left:-23px;">
            <div class="panel panel-success" style="min-height:150px; border:none;">
                <div class="panel-heading" style="font-size:20px;">HUMSS</div>
                    <div class="panel-body" style="font-size:12px;">HUMANITIES AND SOCIAL SCIENCES STRANDS</div>
            </div>
        </div>
        <div class="col-sm-2" style="margin-left:-23px;">
            <div class="panel panel-danger" style="min-height:150px; border:none;">
                <div class="panel-heading" style="font-size:20px;">STEM</div>
                    <div class="panel-body" style="font-size:12px;">SCIENCE TECHNOLOGY ENGINEERING AND MATHEMATICS</div>
            </div>
        </div>
        <div class="col-sm-2" style="margin-left:-23px;">
            <div class="panel panel-warning" style="min-height:150px; border:none;">
                <div class="panel-heading" style="font-size:20px;">TVL</div>
                    <div class="panel-body" style="font-size:12px;">TECHNICAL VOCATIONAL LIVELIHOOD</div>
            </div>
        </div>
        <div class="col-sm-12" style="margin-top:-40px;">
            <h3>Contact us</h3>
                <div class="col-sm-4">
                <h5><b>Columban College Inc. Main Campus</b></h5>
                    <p>No.1 First Street, East Tapinac, Olongapo City, Zambales 2200</p>
                    <p>047-222-3329</p>
                    <p>ColumbanCollege.edu.ph</p>
                    
                </div>

                <div class="col-sm-4">
                <h5><b>Columban College Senior High School</b></h5>
                    <p>No.1 First Street, East Tapinac, Olongapo City, Zambales 2200</p>
                    <p>(+63)936-9311-802</p>
                    <p>CCSdeveloper@gmail.com</p>
                </div>

                <div class="col-sm-4">
                <h5><b>Make A Quiz: Online Quiz Creator</b></h5>
                    <p>No.1 First Street, East Tapinac, Olongapo City, Zambales 2200</p>
                    <p>(+63)936-9311-802</p>
                    <p>makeaquiz.cci@gmail.com</p>
                </div>
        </div>
</div>
<?php require_once 'footer.php' ?>
