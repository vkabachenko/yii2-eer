// go to the action by ajax and send rendering html to modal window

function ajaxModal(link,header) {

    $.get($(link).attr('href'),function(data) {

        $('#modalWindow .modal-header h2').text(header);
        $('#modalWindow .modal-body').html(data);
        $('#modalWindow').modal('show');
    });
    return false;

}

// all click handlers in grid buttons
function clickHandlers() {

    $('.actionUpdate').click(function(){
        return ajaxModal(this,'Редактирование');
    });

    $('#actionCreate').click(function(){
        return ajaxModal(this,'Создание');
    });

    $('.actionDelete').click(function(){
        return ajaxModal(this,'Удаление');
    });
}

// reactivate handlers after each pjax update
$('#pjaxWrap').on('pjax:success',function() {
    clickHandlers();
});

// first run
clickHandlers();
