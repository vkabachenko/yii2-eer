$('#year').click(function(){

  $.get($('#year').attr('href'),function(data) {
    $('#modalWindow .modal-header h2').text('Учебный год');
    $('#modalWindow .modal-body').html(data);
    $('#modalWindow').modal('show');
  });
  return false;
});
