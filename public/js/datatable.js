function datatable(tableId, url){
    console.log('pasting the url'.url);
    $(tableId).DataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "autoWidth": false,
            "lengthMenu": [10, 50, 100, 500, 1000],
            "pageLength": 10,
            "ajax": {
                "url": url,
                "type": "GET",
                "data": function(d) {
                    return $.extend({}, d);
                },
                "error": function(xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            },
            // "initComplete": function() {
            //     $(tableId).DataTable().columns.adjust().responsive.recalc();
            // },
            "dom": '<"top"lBf>rt<"bottom"ip><"clear">',
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
}