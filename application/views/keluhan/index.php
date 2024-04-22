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
                  <form class="forms-sample" action="<?= base_url('Keluhan/insert'); ?>" method="post">
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                        <label>Ruangan</label>
                        <select class="form-control form-control-sm pull-right" id="ruangan" name="ruangan">
                            <option value="">-- Ruang --</option>
                                <?php foreach ($ruang as $cb) : ?>
                                    <option value="<?= $cb['userlevelid']; ?>" <?= set_select('Ruang', $cb['userlevelid']); ?>><?= $cb['userlevelname']; ?></option>
                                <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label>Keterangan</label>
                      <textarea type="text" class="form-control" id="keterangan" name="keterangan"  placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Penyebab</label>
                      <textarea type="text" class="form-control" id="penyebab" name="penyebab" placeholder="Penyebab"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Solusi</label>
                      <textarea type="text" class="form-control" id="solusi" name="solusi" placeholder="Solusi"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Jam Mulai</label>
                      <input type="time" class="form-control" id="jam_mulai" name="jammulai" placeholder="Jam mulai">
                    </div>
                    <div class="form-group">
                      <label>Jam selesai</label>
                      <input type="time" class="form-control" id="jam_selesai" name="jamselesai" placeholder="Jam selesai">
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

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <form name="pencariankeluhan" action="<?= base_url('Keluhan/index'); ?>" method="post">
                    <div class="col-xs-10 pull-right">
                        <div class="input-group input-group-sm">
                            <input name="dtanggalcari" class="form-control" value="<?= $dtanggalcari; ?>" placeholder="Dari Tanggal" type="date"/>
                            <div class="input-group-btn">
                                
                            </div>
                            <input name="stanggalcari" class="form-control" value="<?= $stanggalcari; ?>" placeholder="Sampai Tanggal" type="date"/>
                            <div class="input-group-btn">
                                
                            </div>
                            <?php echo validation_errors(); ?></p>
                            <?php if ($this->session->flashdata('flash')) : ?><?= $this->session->flashdata('flash'); ?>
                                <?php endif; ?>
                                <div class="input-group-btn">
                                    <input type="submit" name="action" value="Cari" class="btn btn-danger">
                                </div>
                                <div class="input-group-btn">
                                    <input type="submit" name="action" value="Print" class="btn btn-light">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="box-body">
                    <div class="box-bodyno-padding">
                        <div style="overflow-x:auto;" class="table-responsive">
                            <table class="d table table-hover table-sm">
                                <thead>
                                    <tr>

                                        <th style="width: 10px">#</th>
                                        <th>Action</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Ruangan</th>
                                        <th>Penyebab</th>
                                        <th>Solusi</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Durasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($keluhan as $d) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?= base_url('Keluhan/delete/').$d['id']; ?>">Delete</a></li>
                                                        <li><a href="<?= base_url('Keluhan/edit/').$d['id']; ?>">Edit</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?= substr($d["tanggal"],0,10); ?></td>
                                            <td><?= $d["keterangan"]; ?></td>
                                            <td><?= getPoli($d["ruangan"], "userlevelname"); ?></td>
                                            <td><?= $d["penyebab"]; ?></td>
                                            <td><?= $d["solusi"]; ?></td>
                                            <td><?= $d["jam_mulai"]; ?></td>
                                            <td><?= $d["jam_selesai"]; ?></td>
                                            <td><?= $d["durasi"]; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="box-footer clearfix">
                <?= $links; ?>
            </div>
        </div>
    </div>
</div>