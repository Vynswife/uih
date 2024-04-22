<!-- cetak_hasil.php -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Print Result</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama pelapor</th>
                        <th>Nomor identifikasi</th>
                        <th>Jenis keluhan</th>
                        <th>Tingkat Urgensi</th>
                        <th>Kontak</th>
                        <th>Lokasi</th>
                        <th>Foto Bukti</th>
                        <th>Penjelasan</th>
                        <th>Status</th>
                        <th>Tanggal Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formulir as $key => $row) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $row->nama_pelapor?></td>
                            <td><?= $row->nomor_identifikasi?></td>
                            <td><?= $row->jenis_keluhan?></td>
                            <td><?= $row->tingkat?></td>
                            <td><?= $row->kontak?></td>
                            <td><?= $row->lokasi?></td>
                            <td><?= $row->foto_bukti?></td>
                            <td><?= $row->penjelasan?></td>
                            <td><?= $row->tanggal_keluhan?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>