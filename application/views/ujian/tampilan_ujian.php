<div class="alert alert-success" role="alert">
    <h4 class="text-center font-weight-bold">Jadwal Ujian</h4>
</div>


<?= $this->session->flashdata('pesan') ?>
<div class="row">
    <div class="col-mad">
        <div class="card">
            <div class="card-body">
               <h5 class="font-weight-bolder text-uppercase">

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