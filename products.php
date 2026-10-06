<?php
/**
 * products.php - DATA LAYER
 * Menyimpan data produk AWAL (default) dalam multidimensional array.
 * Data ini dipakai sebagai isi pertama kali sebelum ada produk yang
 * ditambahkan lewat form.
 */

$katalogDefault = [
    [
        "id"         => "PROD-01",
        "nama"       => "Laptop Asus Pro",
        "kategori"   => "Elektronik",
        "harga"      => 7500000,
        "stok"       => 8,
        "deskripsi"  => "Laptop untuk kebutuhan produktivitas & multitasking."
    ],
    [
        "id"         => "PROD-02",
        "nama"       => "Mouse Wireless",
        "kategori"   => "Aksesoris",
        "harga"      => 125000,
        "stok"       => 2,
        "deskripsi"  => "Mouse tanpa kabel dengan sensor presisi tinggi."
    ],
    [
        "id"         => "PROD-03",
        "nama"       => "RAM DDR5 16GB",
        "kategori"   => "Komponen",
        "harga"      => 950000,
        "stok"       => 12,
        "deskripsi"  => "Modul RAM performa tinggi untuk PC gaming/kerja berat."
    ],
];
