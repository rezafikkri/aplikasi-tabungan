<?php  
    $anggota_id = filter_input(INPUT_GET, 'anggota_id', FILTER_SANITIZE_STRING);
?>
<div class="col-lg-6 col-lg-offset-3">
    <h2 class="judul text-center">Detail Tabungan <span class="small">Reza Sariful Fikri</span></h2>

    <div class="col-lg-12 nopadding-all">
        <select class="mb-10">
            <option selected="">10</option>
        </select>
    </div>

    <div class="col-lg-12 nopadding-all">
        <a href="<?= config::base_url(); ?>" class="btn btn-default pull-right">Kembali!</a>
        <div class="input-group mb-10 pr-5">
            <span class="input-group-addon">Rp</span>
            <input type="text" name="jml_uang" class="form-control" data-jml-uang="" id="jml_uang" placeholder="Jumlah uang...">
            <input type="hidden" name="anggota_id" value="<?= $anggota_id; ?>">
            <div class="input-group-btn">
                <div class="div-loading-btn">
                    <div class="loading-bg btn hidden"></div>
                    <div class="loading-btn hidden"></div>
                    <button class="btn btn-success border-radius-0" id="tambah_tabungan">Tambah</button>
                </div>
                <div class="div-loading-btn">
                    <div class="loading-bg btn hidden"></div>
                    <div class="loading-btn hidden"></div>
                    <button class="btn btn-success" id="ambil_tabungan">Ambil</button>
                </div>
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
<alert></alert>
<script type="text/javascript">
// generate number format
const inputJml_uang = document.querySelector("input#jml_uang");
inputJml_uang.addEventListener('input', e => {
    let hasil = [];
    let penentu = 3;
    const angka = e.target.value.replace(/\./g, '');
    // set angka asli ke object dataset
    e.target.dataset.jmlUang = angka;
    // number format
    angka.split('').reverse().forEach((angka, i) => {
        if(i === penentu) {
            hasil.unshift(`${angka}.`);
            penentu += 3;
        } else {
            hasil.unshift(angka);
        }
    });
    // set hasil number format di input value
    e.target.value = hasil.join('');
});


</script>