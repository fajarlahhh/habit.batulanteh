<div>
    <div wire:ignore.self class="modal fade" id="modal-cetak">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body overflow-auto height-500" id="modal-body-cetak">
                    {!! Session::get('cetak') !!}
                </div>
                <div class="modal-footer">
                    <a href="#" onclick="cetak()" class="btn btn-success">Cetak</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function cetak(timeout = null) {
            var divToPrint = document.getElementById('modal-body-cetak');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<head><link href="/assets/css/app.css" rel="stylesheet" /><link href="/assets/css/default/app.min.css" rel="stylesheet" /></head><body class="bg-white" style="font-family: Tahoma, Geneva, sans-serif; color: #000; margin-bottom: 0px; font-size: 12px" onload="window.print()"><div><div class="m-l-40 m-r-40">' +
                divToPrint.innerHTML +
                '</div></div></body>'
            );
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 100);
        }
    </script>
</div>
