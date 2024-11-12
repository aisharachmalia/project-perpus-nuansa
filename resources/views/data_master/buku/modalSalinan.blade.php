<div class="modal fade text-left" id="editSalinan" tabindex="1" role="dialog" aria-labelledby="modalEditSalinan"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalEdit">Perbaharui Buku</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form" id="form_buku_salinan_upd" method="PUT" enctype="multipart/form-data">
                    <div class="row justify-content-around">
                        <div class="col-md-4">
                            <label>Nama Buku Salinan</label>
                            <input type="hidden" id="id_dsbk" name="id_dsbk">
                            <input type="text" id="dsbuku_no_salinan" class="form-control" placeholder="Nama Buku Salinan"
                                name="dsbuku_no_salinan">
                            <span id="no-error" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Kondisi</label>
                            <div id="dsbuku_kondisi">      

                            </div>
                            <span id="kondisi-error" class="text-danger"></span>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateS">Simpan</button>
            </div>
        </div>
    </div>
</div>

