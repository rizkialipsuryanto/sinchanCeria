<style>
    .d {
        white-space: nowrap;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="box-body no-padding">
                    <div style="overflow-x: auto;" class="table-responsive">
                        <h4 class="card-title">Tambah Keluhan</h4>
                  <p class="card-description">
                    Form Tambah Keluhan
                  </p>
                    <form class="forms-sample" action="<?= base_url('Keluhan/Update'); ?>" method="post">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <input type="hidden" class="form-control" id="id" name="txid" value="<?= $keluhan[0]['id']; ?>">
                        <input type="date" class="form-control" id="tanggal" name="txtanggal" value="<?= substr($keluhan[0]['tanggal'],0,10) ?>">
                      </div>
                      <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="txketerangan" value="<?= $keluhan[0]['keterangan']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Ruangan</label>
                        <select class="form-control form-control-sm pull-right" id="ruangan" name="txruangan">
                            <option value="">-- Ruang --</option>
                            
                                <?php foreach ($ruang as $cb) : ?>
                                    <option value="<?= $cb['userlevelid']; ?>" <?= set_select('Ruang', $cb['userlevelid']); ?>><?= $cb['userlevelname']; ?></option>
                                <?php endforeach ?>
                            
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Penyebab</label>
                        <input type="text" class="form-control" id="penyebab" name="txpenyebab" value="<?= $keluhan[0]['penyebab']; ?>" >
                      </div>
                      <div class="form-group">
                        <label>Solusi</label>
                        <input type="text" class="form-control" id="solusi" name="txsolusi" value="<?= $keluhan[0]['solusi']; ?>" >
                      </div>
                      <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" class="form-control" id="jam_mulai" name="txjammulai" value="<?= $keluhan[0]['jam_mulai']; ?>" >
                      </div>
                      <div class="form-group">
                        <label>Jam selesai</label>
                        <input type="time" class="form-control" id="jam_selesai" name="txjamselesai" value="<?= $keluhan[0]['jam_selesai']; ?>" >
                      </div>

                      <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>