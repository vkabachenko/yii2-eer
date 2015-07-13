var link = $('a.linkedFiles');

link.click(function() {
   var url = link.attr('href');
   $.get(url,function(data) {
       $('#modalWindow .modal-body').html(data);
       $('#modalWindow').modal('show');
   });
   return false;
});
