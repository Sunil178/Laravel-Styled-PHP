<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <script src="/assets/vendor/libs/jquery/jquery.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    <body>
        <select class="js-data-example-ajax" style="width: 14vw;">
            <option value=""> -- select lead emulators -- </option>
        </select>
        <script>
            $('.js-data-example-ajax').select2({
                theme: 'bootstrap-5',
                ajax: {
                    // url: 'https://api.github.com/search/repositories',
                    url: '/leads/emulators',
                    dataType: 'json',
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
                    }
                }
            });
        </script>
    </body>
</html>