<?php require_once 'autoload.php';
require_once 'header.php' ?>
    
    <?= $Util->printMessage() ?>
    <?= $Util->printError() ?>

        <h1>Welcome <?= $_SESSION['fld_username'] ?>! </h1>

                <div class="col-sm-12" style="padding-top:10px;">

                    <div class="col-sm-3" style="min-height:280px; border-radius:6px; margin-left:13px;">
                        <a href="<?= $config['base'] ?>/student_take_quiz.php"><button class="btn btn-success btn-lg" style="height:230px; width:100%; font-size:22px;"><i class="fa fa-pencil-square-o fa-4x" style="color:#ffff66;"></i><br>Take A Quiz</button></a>
                    </div>

                    <div class="col-sm-3" style="min-height:280px; border-radius:6px; margin-left:-15px;">
                        <a href="<?= $config['base'] ?>/student_take_quiz.php"><button class="btn btn-primary btn-lg" style="height:230px; width:100%; font-size:22px;"><i class="fa fa-th-list fa-4x" style="color:#ffff66;"></i><br>My Quizzes</button></a>
                    </div>

                    <div class="col-sm-3" style="min-height:280px; border-radius:6px; margin-left:-15px;">
                        <button class="btn btn-warning btn-lg" style="height:230px; width:100%; font-size:22px;"><i class="fa fa-users fa-4x" style="color:#ffff66;"></i><br>My Grades</button>
                    </div>

                    <div class="col-sm-3" style="min-height:280px; border-radius:6px; margin-left:-15px;">
                        <button class="btn btn-info btn-lg" style="height:230px; width:100%; font-size:22px;"><i class="fa fa-book fa-4x" style="color:#ffff66;"></i><br>Profile</button>
                    </div>

                </div>
                <br>

                        <label><h5>My On-going Quizzes</h5></label>
                            <table class="table table-hover" data-toggle="table" data-pagination="true" style="min-height:185px; max-height:185px;">
                        
                                <thead>
                                    <th data-sortable="true">Quiz Title</th>
                                    <th data-sortable="true">Room</th>
                                    <th data-sortable="true">Date Started</th>
                                    <th data-sortable="true">Time Left</th>
                                </thead>
                            </table>


<?php require_once 'footer.php' ?>
