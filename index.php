<?php
/**
 * index.php - PRESENTATION LAYER
 * Menangani form tambah produk ($_POST -> validasi) sekaligus
 * menampilkan tabel katalog produk dalam satu halaman.
 */
require_once 'products.php';   // menyediakan $katalogDefault
require_once 'functions.php';  // menyediakan fungsi-fungsi helper

$katalog = $katalogDefault;
$errors = [];
$berhasil = false;

// Tangani submit form tambah produk
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1) TANGKAP data dari form pakai $_POST
    $dataForm = [
        "nama"      => $_POST["nama"] ?? "",
        "kategori"  => $_POST["kategori"] ?? "",
        "price"     => $_POST["price"] ?? "",
        "stock"     => $_POST["stock"] ?? "",
        "deskripsi" => $_POST["deskripsi"] ?? "",
    ];

    // 2) VALIDASI pakai fungsi dari functions.php
    $errors = validasiProduk($dataForm);

    // 3) Kalau valid, tambahkan produk baru ke $katalog (tampil sementara)
    if (empty($errors)) {
        $produkBaru = [
            "id"        => buatIdProdukBaru($katalog),
            "nama"      => $dataForm["nama"],
            "kategori"  => $dataForm["kategori"],
            "harga"     => (float) $dataForm["price"],
            "stok"      => (int) $dataForm["stock"],
            "deskripsi" => $dataForm["deskripsi"],
        ];

        $katalog[] = $produkBaru;
        $berhasil = true;
    }
}

$totalNilaiGudang = hitungTotalNilaiStok($katalog);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Product Information System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        h1 { color: #222; }
        .ringkasan { background: #fff; padding: 15px 20px; border-radius: 8px;
                     margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .box { max-width: 480px; background: #fff; padding: 25px; border-radius: 8px;
               box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 25px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 18px; padding: 10px 16px; background: #2c3e50;
                 color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        .error  { color: #c0392b; font-size: 13px; margin-top: 4px; }
        .sukses { background: #eafbea; color: #2e8b57; padding: 10px 15px;
                  border-radius: 5px; margin-bottom: 15px; }
        .catatan{ background: #fff8e1; color: #7a5c00; padding: 10px 15px;
                  border-radius: 5px; font-size: 13px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        th, td { padding: 10px 14px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        th { background: #2c3e50; color: #fff; }
        .baris-aman    { background: #eafbea; }
        .baris-menipis { background: #fff8e1; }
        .baris-kritis  { background: #fdecea; font-weight: bold; }
        .status-tag { padding: 3px 8px; border-radius: 4px; font-size: 12px; color: #fff; }
        .status-tag.Aman    { background: #2e8b57; }
        .status-tag.Menipis { background: #d4a017; }
        .status-tag.Kritis  { background: #c0392b; }
    </style>
</head>
<body>

    <h1>📦 Product Information System</h1>

    <div class="ringkasan">
        <strong>Total Nilai Aset Gudang:</strong> <?php echo formatRupiah($totalNilaiGudang); ?><br>
        <strong>Jumlah Jenis Produk:</strong> <?php echo count($katalog); ?>
    </div>

    <h3>➕ Tambah Produk Baru</h3>

    <div class="catatan">
        ⚠️ Catatan: karena belum pakai database (MySQL), produk baru cuma
        tampil sementara. Kalau halaman ini di-refresh, datanya balik ke
        data default di <code>products.php</code>.
    </div>

    <?php if ($berhasil): ?>
        <div class="sukses">✅ Produk berhasil ditambahkan (sementara), lihat di tabel bawah.</div>
    <?php endif; ?>

    <div class="box">
        <form method="post" action="">
            <label>Nama Produk</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>">
            <?php if (isset($errors["nama"])): ?><div class="error"><?php echo $errors["nama"]; ?></div><?php endif; ?>

            <label>Kategori</label>
            <input type="text" name="kategori" value="<?php echo htmlspecialchars($_POST['kategori'] ?? ''); ?>">
            <?php if (isset($errors["kategori"])): ?><div class="error"><?php echo $errors["kategori"]; ?></div><?php endif; ?>

            <label>Harga</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>">
            <?php if (isset($errors["price"])): ?><div class="error"><?php echo $errors["price"]; ?></div><?php endif; ?>

            <label>Stok</label>
            <input type="text" name="stock" value="<?php echo htmlspecialchars($_POST['stock'] ?? ''); ?>">
            <?php if (isset($errors["stock"])): ?><div class="error"><?php echo $errors["stock"]; ?></div><?php endif; ?>

            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="2"><?php echo htmlspecialchars($_POST['deskripsi'] ?? ''); ?></textarea>

            <button type="submit">Simpan Produk</button>
        </form>
    </div>

    <h3>📋 Katalog Produk</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($katalog as $produk):
                $status = cekStatusStok($produk["stok"]);
                $cssClass = warnaBarisStok($status);
            ?>
            <tr class="<?php echo $cssClass; ?>">
                <td><?php echo $produk["id"]; ?></td>
                <td><?php echo $produk["nama"]; ?></td>
                <td><?php echo $produk["kategori"]; ?></td>
                <td><?php echo formatRupiah($produk["harga"]); ?></td>
                <td><?php echo $produk["stok"]; ?></td>
                <td><span class="status-tag <?php echo $status; ?>"><?php echo $status; ?></span></td>
                <td><?php echo $produk["deskripsi"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
