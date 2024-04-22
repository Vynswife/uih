<div class="content-body">

            
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

    <h2>Laporan PDF</h2>
    <table>
        <thead>
            <tr>
                        <th>No</th>
                        <th>Nama pelapor</th>
                        <th>Nomor identifikasi</th>
                        <th>Jenis keluhan</th>
                        <th>Tingkat Urgensi</th>
                        <th>Kontak</th>
                        <th>Lokasi</th>
                        <th>Penjelasan</th>
                        <th>Status</th>
                        <th>Tanggal Keluhan</th>
            </tr>
        </thead>
        <tbody>
              <?php foreach ($laporan as $key => $row) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $row->nama_pelapor?></td>
                            <td><?= $row->nomor_identifikasi?></td>
                            <td><?= $row->jenis_keluhan?></td>
                            <td><?= $row->tingkat?></td>
                            <td><?= $row->kontak?></td>
                            <td><?= $row->lokasi?></td>
                            <td><?= $row->penjelasan?></td>
                            <td><?= $row->tanggal_keluhan?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>