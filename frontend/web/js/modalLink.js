$('a').click(function(ev) {

    var target = $(ev.target);
    if (target.is('.linkedFiles')) {
        var header = 'Документы';
    }
    else
    if (target.is('#year')) {
        header = 'Учебный год';
    }

    if (header) {
        var url = target.attr('href');
        $.get(url,function(data) {
            $('#modalWindow .modal-header h2').text(header);
            $('#modalWindow .modal-body').html(data);
            $('#modalWindow').modal('show');
        });
        return false;
    }

    });








