function createTable( tableID, settingsObject) {
      var def = { pageLength: 50, "language": { "paginate": { "first" : "Pierwsza", "last" : "Ostatnia", "previous": "Poprzednia", "next": "Następna"}, "lengthMenu": "_MENU_ rekordów na stronę", "zeroRecords": "Brak wyników", "info": "Strona _PAGE_ z _PAGES_", "infoEmpty": "Brak wyników", "infoFiltered": "(przeszukano _MAX_ wyników)","search": "Szukaj: "}}
      var settings = $.extend(def, settingsObject)
      //var def = {};
      $( tableID ).dataTable( settings );
  }
