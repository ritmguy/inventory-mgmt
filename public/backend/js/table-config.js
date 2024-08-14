// Document on ready function 

    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

    
    $('#dataTable').DataTable({
        columnDefs: [{
            bSortable: false,
            // targets: [5]
        }],
        dom: 'lBfrtip',
        buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, ':visible']

                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2, 5]
                }
            },

            'csv', 'zip', 'pdf'

        ],

    });
