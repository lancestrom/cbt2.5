<div class="alert alert-success" role="alert">
    <h4 class="text-center font-weight-bold">Jadwal Ujian</h4>
</div>


<?= $this->session->flashdata('pesan') ?>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <h5>
                    <button type="button" class="btn btn-primary btn-sm text-uppercase font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                        Tambah Ujian
                    </button>
                </h5>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Ujian</th>
                                <th scope="col">Nama Mapel</th>
                                <th scope="col">Tanggal Ujian</th>
                                <th scope="col">Waktu Ujian Mulai</th>
                                <th scope="col">Waktu Ujian selesai</th>
                                <th scope="col">Durasi Ujian</th>
                                <!-- <th scope="col">Waktu Ujian</th> -->
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <?php
                                $no = 1;
                                foreach ($ujian as $row) {
                                ?>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <h4 class="badge badge-primary text-uppercase"><?= $row['id_jadwal']; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="badge badge-info text-uppercase"><?= $row['nama_mapel']; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="badge badge-info"><?= $row['tanggal_mulai']; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="badge badge-success"><?= $row['waktu_mulai']; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="badge badge-danger"><?= $row['waktu_selesai']; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="badge badge-secondary"><?= number_format($row['waktu']); ?> Menit</h4>
                                    </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-uppercase font-weight-bolder" id="exampleModalLabel">Tambah Ujian</h5>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>