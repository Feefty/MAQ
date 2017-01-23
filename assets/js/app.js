$(function() {
    $('[data-toggle="select"]').selectpicker();
    $('[data-toggle="tooltip"]').tooltip();

    $('#add-question-modal').on('show.bs.modal', function(e) {
        var category = $(e.relatedTarget).data('question-category');
        $('.question').html('');
        addQuestion(category);
    });

    $('#registration [name="role"]').on('change', function() {
        if ($(this).val() == 'teacher') {
            $('#registration .student-fields').hide();
        } else {
            $('#registration .student-fields').show();
        }
    });
    $('[data-toggle="print"]').on('click', function() {
        var target = $(this).data('target');
        $(target).printThis();
    });
});
var questionNums = 0;
var answerOrder = 0;

function matchingTypeOptions(e, options) {
    var val = $(e).val();
    $('option', e).each(function(k, v) {
        if (v.val() == val) {
            v.hide();
        } else {
            v.show();
        }
    });
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function addAnswer(type, e, i) {
    var answerFormat = '';
    switch(type) {
        case 'mc':
            answerFormat = `<div class="answers-bit">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <input type="text" name="answers[`+ i +`][]" class="form-control" value="">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="corrects[`+ i +`][]">
                                            <option value="0">X Wrong</option>
                                            <option value="1">&#10004 Correct</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-default form-control" onclick="deleteAnswer(this)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
            break;
        case 'sa':
            answerFormat = `<div class="answers-bit">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input type="text" name="answers[`+ i +`][]" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-default form-control" onclick="deleteAnswer(this)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
            break;
        case 'mt':
            answerFormat = `<div class="answers-bit">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <input type="text" name="answers[`+ i +`][][`+ answerOrder +`]" class="form-control">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" name="answers[`+ i +`][][`+ answerOrder +`]" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-default form-control" onclick="deleteAnswer(this)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
            answerOrder++;
            break;
        case 'cb':
            answerFormat = `<div class="answers-bit">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <input type="text" name="answers[`+ i +`][]" class="form-control" value="">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="corrects[`+ i +`][]">
                                            <option value="0">X Wrong</option>
                                            <option value="1">&#10004 Correct</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-default form-control" onclick="deleteAnswer(this)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
            break;
    }

    $(e).parents('.answers').find('.answer-holder').append(answerFormat);
}

function deleteAnswer(e) {
    $(e).parents('.answers-bit').remove();
}

function deleteQuestion(e) {
    $(e).parents('.question-bit').remove();
}

function addQuestion(type) {
    var questionFormat = '';
    var questionBit = `<div class="col-sm-9 col-xs-12">
                            <textarea name="questions[`+ questionNums +`]" class="form-control" placeholder="Question"></textarea>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <label class="btn btn-warning btn-file">
                                        <input type="file" name="images_`+ questionNums +`" accept="image/*">
                                        <i class="fa fa-upload fa-fw"></i> Image
                                    </label>
                                </span>
                                <span class="input-group-btn">
                                    <label class="btn btn-danger btn-file">
                                        <input type="file" name="videos_`+ questionNums +`" accept="video/*">
                                        <i class="fa fa-upload fa-fw"></i> Video
                                    </label>
                                </span>
                            </div>
                        </div>`;
    switch(type) {
        case 'mc':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Multiple Choice</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="mc">
                        <div class="row">
                            `+ questionBit +`
                        </div>
                        <div class="answers">
                            <h4>Answer Choice</h4>
                            <div class="answer-holder"></div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" onclick="addAnswer('mc', this, `+ questionNums +`)"><i class="fa fa-plus fa-fw"></i> Add Answer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
        case 'tf':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>True / False</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="tf">
                        <div class="row">
                            `+ questionBit +`
                        </div>
                        <div class="answers">
                            <h4>Answer</h4>
                            <div class="answer-holder">
                                <label class="radio-inline">
                                    <input type="radio" name="answers[`+ questionNums +`]" value="true" checked> True
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="answers[`+ questionNums +`]" value="false"> False
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
        case 'sa':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Short Answer</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="sa">
                        <div class="row">
                            `+ questionBit +`
                        </div>
                        <div class="answers">
                            <h4>Answers</h4>
                            <div class="answer-holder"></div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" onclick="addAnswer('sa', this, `+ questionNums +`)"><i class="fa fa-plus fa-fw"></i> Add Answer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
        case 'fb':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Fill in the Blank</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="fb">
                        <div class="help-block">Use <i>[<strong>answer1,answer2</strong>]</i> to create a blank answer to fill in your question.<br>
                        ex. [Aquino] was the President of the Philippines.<br>
                        So any words that goes inside this bracket "[]" will be the answer to that specific blank.</div>
                        <div class="row">
                            `+ questionBit +`
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
        case 'cb':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Checkboxes</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="cb">
                        <div class="row">
                            `+ questionBit +`
                        </div>
                        <div class="answers">
                            <h4>Answers</h4>
                            <div class="answer-holder"></div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" onclick="addAnswer('cb', this, `+ questionNums +`)">
                                        <i class="fa fa-plus fa-fw"></i> Add Answer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
        case 'mt':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Matching Type</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="mt">
                        <div class="row">
                            `+ questionBit +`
                        </div>
                        <div class="answers">
                            <h4>Answers</h4>
                            <div class="answer-holder"></div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary" onclick="addAnswer('mt', this, `+ questionNums +`)">
                                        <i class="fa fa-plus fa-fw"></i> Add Answer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
        case 'ew':
            questionFormat = `<div class="question-bit" data-question-index="`+ questionNums +`">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Essay Writing</strong>
                        <button type="button" class="close" onclick="deleteQuestion(this)">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="question_types[`+ questionNums +`]" value="ew">
                        <div class="help-block">The auto summarization of this quiz will disable if this category which is Essay Writing is in the quiz questions</div>
                        <div class="row">
                            `+ questionBit +`
                        </div>
                    </div>
                </div>
            </div><!-- question bit -->`;
            break;
    }
    $('.question').append(questionFormat);
    questionNums++;
}

$(function() {
    if ($('#question-category-chart').length > 0) {
        var url = $('#question-category-chart').data('url');
        $.get(url, function(response) {
            var response = JSON.parse(response);
            var myPieChart = new Chart($('#question-category-canvas'), {
                type: 'pie',
                data: response
            });
        });
    }

    if ($('#student-gender-chart').length > 0) {
        var url = $('#student-gender-chart').data('url');
        $.get(url, function(response) {
            var response = JSON.parse(response);
            var myPieChart = new Chart($('#student-gender-canvas'), {
                type: 'doughnut',
                data: response
            });
        });
    }

    if ($('#subject-quiz-chart').length > 0) {
        var url = $('#subject-quiz-chart').data('url');
        $.get(url, function(response) {
            var response = JSON.parse(response);
            var myPieChart = new Chart($('#subject-quiz-canvas'), {
                type: 'horizontalBar',
                data: response
            });
        });
    }

    if ($('#quiz-author-chart').length > 0) {
        var url = $('#quiz-author-chart').data('url');
        $.get(url, function(response) {
            var response = JSON.parse(response);
            var myPieChart = new Chart($('#quiz-author-canvas'), {
                type: 'horizontalBar',
                data: response
            });
        });
    }
});
