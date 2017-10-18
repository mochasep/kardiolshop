<div class="modal fade" id="lineModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Beli lewat LINE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Pesan item ini dengan cara menambahkan LINE account @ihx2991p. Kemudian ketik LIHAT_<span
                        id="item-1"></span>
                untuk melihat detail barang dan ketik BELI_<span id="item-2"></span> untuk membeli barang.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#lineModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var itemid = button.data('itemid')
        var modal = $(this)
        modal.find('.modal-body > #item-1').text(itemid)
        modal.find('.modal-body > #item-2').text(itemid)
    })
</script>