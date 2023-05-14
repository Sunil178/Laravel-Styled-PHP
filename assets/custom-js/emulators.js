function fetchEmulators() {
    return {
         ajax: {
              url: '/leads/emulators',
              data: function (params) {
                   var query = {
                        emulator_name: params.term,
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
