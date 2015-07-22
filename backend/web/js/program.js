$('#faculties').change(function(){

    var $this = $(this);

    var program = $('#program');

    // clear previous data
    program.children().each(function(index) {
            $(this).remove();
    });
    var id_faculty = $this.val();

        $.ajax({
            'url' : $this.data('url'),
            'data' : { 'id_faculty' : id_faculty }, // request (GET by default)
            'dataType' : 'json',
            'success' : fillProgram,
            'error' : function() {
                console.log('Error occured while processing ajax request')
            }
        });
});

$('#faculties').change(); // initial


// fill program select tag
function fillProgram(dataArr) {

    $.each(dataArr,function(index,data) {

        $('<option></option>').
            appendTo(program).
            val(data.id).
            text(data.fullName);
    })

}


