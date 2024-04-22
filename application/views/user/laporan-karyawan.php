                            <table class="table table-md" border="1">
                                <thead>
                                    <tr>
                                        <th class="col">#</th>
                                        <th class="col">Tanggal</th>
                                        <th class="col">Task detail</th>
                                        <th class="col">Catatan</th>
                                        <th class="col">Jumlah</th>
                                        <th class="col">Satuan</th>
                                        <th class="col">verif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($daily as $daftar) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td><?= $daftar["tanggal"]; ?></td>
                                            <td><?= $daftar["id_tasks_detail"]; ?></td>
                                            <td><?= $daftar["catatan"]; ?></td>
                                            <td><?= $daftar["jumlah"]; ?></td>
                                            <td><?= $daftar["satuan"]; ?></td>
                                            <td><?= $daftar["verif"]; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>