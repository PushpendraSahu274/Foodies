function datatable(tableId, url){

    // Check if already initialized and destroy it
    if ($.fn.DataTable.isDataTable(tableId)) {
        $(tableId).DataTable().clear().destroy();
    }
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