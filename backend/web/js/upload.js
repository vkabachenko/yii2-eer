$('#updateForm').on('beforeSubmit',function(){ // runs after validation

    var form = document.forms.uploadForm;
    var formData = new FormData(form);

    $.ajax({
        url: $(this).attr('action'), // url in form's action
        type: 'POST',
        data: formData,
        contentType: false, // обязательно
        processData: false, // для FormData
        success: function(data) {            // update action returns success
            var interval = data ? 1000 : 0; //timeout interval for creation - 1 sec
            $('#modalWindow .modal-body').html(data); // alert message if needed
            // show alert message and hide
            setTimeout(function(){
                $('#modalWindow').modal('hide'); // hide modal window
                $.pjax.reload({container:"#pjaxWrap"}); // reload grid
            },interval);
        }
    });

    return false; // stops further submitting actions

});
