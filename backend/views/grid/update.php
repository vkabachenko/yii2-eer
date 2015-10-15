
<!-- Additional -->

<!-- Js script for ajax submitting form -->

<?php
$script =
    <<<JS

$('#updateForm').on('beforeSubmit',function(){ // runs after validation

    $.post( // method - post
        $(this).attr('action'), // url in form's action
        $(this).serialize(),    // all form's data - to query string
        function(data) {            // update action returns success
                    var interval = data ? 1000 : 0; //timeout interval for creation - 1 sec
                    $('#modalWindow .modal-body').html(data); // alert message
                                                              // or html with validation errors
                    var scriptPos = data.indexOf('\$script');
                    var htmlCode = data.substring(0, scriptPos);

                    if (htmlCode.indexOf('has-error') != -1) {

                        return false;
                    }

                    // show alert message and hide
                    setTimeout(function(){
                        $('#modalWindow').modal('hide'); // hide modal window
                        $.pjax.reload({container:"#pjaxWrap"}); // reload grid
                    },interval);
        });
    return false; // stops further submitting actions
});
JS;
$this->registerJs($script);




