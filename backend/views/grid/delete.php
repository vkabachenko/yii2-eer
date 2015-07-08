<!-- Additional -->

<!-- Js script for ajax clicking button -->

<?php

$script =
    <<<JS

$('#deleteButton').click(function(){

    $.post(
        $(this).attr('href'),
        {'approve': 'yes'},
        function() {
                    $('#modalWindow').modal('hide');
                    $.pjax.reload({container:"#pjaxWrap"});
        });

    return false;

});

JS;

$this->registerJs($script);
