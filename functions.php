<?php
/**
 * functions.php - PROCESSING LAYER
 * Repositori fungsi/helper bisnis.
 */

/**
 * Menghitung total nilai aset gudang.
 * Total nilai = jumlah dari (harga x stok) setiap produk.
 */
function hitungTotalNilaiStok($katalog)
{
    $totalNilai = 0;
    foreach ($katalog as $produk) {
        $totalNilai += $produk["harga"] * $produk["stok"];
    }
    return $totalNilai;
}

/**
 * Menentukan status stok sebuah produk berdasarkan aturan bisnis.
 */
function cekStatusStok($stok)
{
    if ($stok < 3) {
        return "Kritis";
    } elseif ($stok <= 10) {
        return "Menipis";
    } else {
        return "Aman";
    }
}

/**
 * Mengubah label status stok menjadi nama CSS class.
 */
function warnaBarisStok($status)
{
    switch ($status) {
        case "Kritis":
            return "baris-kritis";
        case "Menipis":
            return "baris-menipis";
        default:
            return "baris-aman";
    }
}

/**
 * Memformat angka menjadi format mata uang Rupiah sederhana.
 */
function formatRupiah($angka)
{
    return "Rp " . number_format($angka, 0, ",", ".");
}

/**
 * Memvalidasi data produk baru dari form ($_POST).
 * Mengembalikan array $errors. Kalau kosong berarti data valid.
 *
 * @param array $data Data mentah dari $_POST (nama, kategori, price, stock, deskripsi)
 * @return array $errors
 */
function validasiProduk($data)
{
    $errors = [];

    if (trim($data["nama"] ?? "") === "") {
        $errors["nama"] = "Nama produk wajib diisi.";
    }

    if (trim($data["kategori"] ?? "") === "") {
        $errors["kategori"] = "Kategori wajib diisi.";
    }

    $priceValid = filter_var($data["price"] ?? "", FILTER_VALIDATE_FLOAT);
    if ($priceValid === false || $priceValid <= 0) {
        $errors["price"] = "Harga harus berupa angka dan lebih besar dari 0.";
    }

    $stockValid = filter_var($data["stock"] ?? "", FILTER_VALIDATE_INT);
    if ($stockValid === false || $stockValid < 0) {
        $errors["stock"] = "Stok harus berupa angka bulat dan tidak boleh negatif.";
    }

    return $errors;
}

/**
 * Membuat ID produk baru otomatis berdasarkan jumlah produk saat ini.
 * Contoh: produk ke-4 -> PROD-04
 */
function buatIdProdukBaru($katalog)
{
    $nomor = count($katalog) + 1;
    return "PROD-" . str_pad($nomor, 2, "0", STR_PAD_LEFT);
}
