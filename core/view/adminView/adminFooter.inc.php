<!-- Core Scripts - Include with every page -->
<script src="../assets/plugins/jquery-1.10.2.js"></script>
    <script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="../assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../assets/plugins/pace/pace.js"></script>
    <script src="../assets/scripts/siminta.js"></script>
    <script src="../assets/font-awesome2/js/all.js"></script>
    <!-- Page-Level Plugin Scripts-->
    <script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/plugins/sweetAlert/sweetalert.min.js"></script>
    <script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
        <script>
        $(document).ready(function () {
            $('#dataTabless-example').dataTable();
        });
    </script>
     <script>
        $(document).ready(function () {
            $('#dataTabless-examplee').dataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#dataTabless-tax-example').dataTable();
        });
    </script>
     <script>
        $(document).ready(function () {
            $('#dataTablesss-tax-example').dataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#dataTablesss-state-example').dataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#attendance-record-Table').dataTable();
        });

        $(document).ready(function () {
            $('#leave-settings').dataTable();
        });
        $(document).ready(function () {
            $('#allowances').dataTable();
        });
        $(document).ready(function () {
            $('#deductions').dataTable();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#paymentsHistoryTable').dataTable();
        });
    </script>

    <script type='text/javascript'>
         function printData() {
            var divToPrint=document.getElementById("printTable");
        /* var printWindow = window.open('', '', 'height=400,width=600');
        printWindow.document.write(divToPrint.outerHTML);
        printWindow.print(); */

                var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;

        var mywindow = window.open('', 'PRINT', 'height=600,width=800');


        mywindow.document.write('<html><head><base href="/" /><title>' + document.title + '</title>');
        mywindow.document.write('<style type="text/css" media="print" />table { width: 100%; }</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h3> Attendance Sheet as of ' + today + '</h3>');
        mywindow.document.write(divToPrint.outerHTML);
        mywindow.document.write('</body></html>');

    }

    function printLeaveRequests() {
            var divToPrint=document.getElementById("printTable");
        /* var printWindow = window.open('', '', 'height=400,width=600');
        printWindow.document.write(divToPrint.outerHTML);
        printWindow.print(); */

                var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;

        var mywindow = window.open('', 'PRINT', 'height=600,width=800');


        mywindow.document.write('<html><head><base href="/" /><title>' + document.title + '</title>');
        mywindow.document.write('<style type="text/css" media="print" />table { width: 100%; }</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h3> Leave Requests </h3>');
        mywindow.document.write(divToPrint.outerHTML);
        mywindow.document.write('</body></html>');

    }
    </script>

<script type='text/javascript'>
         function printAttendanceRecordTable() {
            var divToPrint=document.getElementById("printAttendanceRecordTable");
        var printWindow = window.open('', '', 'height=400,width=600');
        printWindow.document.write(divToPrint.outerHTML);
        printWindow.print(); 

    }
    </script>
