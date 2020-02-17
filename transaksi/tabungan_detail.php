<div class="col-lg-6 col-lg-offset-3 mt-30">
    <h2 class="judul text-center">Detail Tabungan</h2>

    <div class="col-lg-12 nopadding-all">
        <div class="list-group">
            <li class="list-group-item list-group-item-warning">
                <h2 class="list-group-item-heading">Reza Sariful Fikri</h2>
                <p class="list-group-item-text mb-10">Rp 300.000</p>
                <p class="list-group-item-text">Bergabung sejak 1 Januari 2019</p>
            </li>
            <li class="list-group-item">
                <p class="list-group-item-text mb-10">Untuk meng-ubah Nama anggota, Masukkan Nama Lengkap anggota lalu klik tombol simpan</p>
                <form>
                    <label>Nama</label>
                    <input class="form-control" type="text" name="nama" placeholder="Nama Lengkap...">
                </form>
            </li>
        </div>
        <a href="<?= config::base_url(); ?>" class="btn btn-default mb-20 padding-l-10px">Kembali!</a>
        <button class="btn btn-success mb-20">Simpan!</button>
    </div>

    <div class="col-lg-12 nopadding-all">
        <select class="mb-10">
            <option selected="" disabled="">10</option>
        </select>
    </div>

    <div class="col-lg-12 nopadding-all">
        <div class="input-group mb-10">
            <span class="input-group-addon">Rp</span>
            <input type="text" class="form-control" placeholder="Jumlah uang...">
            <div class="input-group-btn">
                <button class="btn btn-success">Tambah</button>
                <button class="btn btn-success">Ambil</button>
            </div>
        </div>
    </div>

    <div class="col-lg-12 nopadding-all mb-100">
        <div class="list-group">
            <li class="list-group-item list-group-item-warning">
                <h4 class="list-group-item-heading">Riwayat Transaksi <span class="badge normal">10</span></h4>
            </li>
            <!-- List group -->
            <li class="list-group-item item-yes">
                <h4 class="list-group-item-heading">Rina</h4> 
                <p class="list-group-item-text mb-10">3 Januari 2020, 18:13 pm</p>
                <p class="list-group-item-text"><strong>Aksi:</strong> Tambah Tabungan</p>
                <span class="badge">Rp 30.000</span>
            </li>
            <li class="list-group-item item-yes">
                <h4 class="list-group-item-heading">Rini</h4> 
                <p class="list-group-item-text">3 Januari 2019, 03:13 pm</p>
                <span class="badge">Rp 40.000</span>
            </li>
            <li class="list-group-item item-yes">
                <h4 class="list-group-item-heading">Rini</h4> 
                <p class="list-group-item-text">2 Maret 2020, 19:20 pm</p>
                <span class="badge">Rp 3.000</span>
            </li>
            <li class="list-group-item item-yes">
                <h4 class="list-group-item-heading">Rina</h4> 
                <p class="list-group-item-text">3 Januari 2020, 12:00 pm</p>
                <span class="badge">Rp 100.000</span>
            </li>
        </div>
    </div>
</div>