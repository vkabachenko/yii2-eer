var link = $('a.linkedFiles');

link.click(function(ev) {
   var target = $(ev.target);
   var url = target.attr('href');
   $.get(url,function(data) {
       $('#modalWindow .modal-body').html(data);
       $('#modalWindow').modal('show');
   });
   return false;
});
