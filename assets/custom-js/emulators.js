function fetchEmulators() {
     select_gameplay = $('[select-gameplay="true"]').length;
     gameplay = {};
     if (select_gameplay > 0) {
          gameplay.gameplay = true;
     }
     return {
         ajax: {
              url: '/leads/emulators',
              data: function (params) {
                   var query = {
                        emulator_name: params.term,
                        ...gameplay
                   }
                   return query;
              },
              processResults: function (data) {
                   return {
                        results: data
                   };
              },
              cache: true,
         }
    }
}
