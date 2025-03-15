<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];
    $cover = '';

    // Upload gambar
    if ($_FILES['cover']['name']) {
        $target_dir = __DIR__ . "/uploads/"; // Path absolut ke folder uploads
        $target_file = $target_dir . basename($_FILES['cover']['name']);
        
        // Cek apakah file berhasil diupload
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)) {
            echo "File berhasil diupload: " . $target_file;
            $cover = $_FILES['cover']['name'];
        } else {
            echo "Gagal mengupload file.";
            print_r($_FILES); // Tampilkan informasi file untuk debugging
            exit();
        }
    }

    // Simpan data ke database
    $query = "INSERT INTO buku (judul, penulis, tahun_terbit, genre, cover) VALUES ('$judul', '$penulis', '$tahun_terbit', '$genre', '$cover')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Tambah Buku</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="judul" class="block text-gray-700">Judul:</label>
                <input type="text" name="judul" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="penulis" class="block text-gray-700">Penulis:</label>
                <input type="text" name="penulis" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="tahun_terbit" class="block text-gray-700">Tahun Terbit:</label>
                <input type="number" name="tahun_terbit" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="genre" class="block text-gray-700">Genre:</label>
                <input type="text" name="genre" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="cover" class="block text-gray-700">Cover Buku:</label>
                <input type="file" name="cover" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Tambah
            </button>
        </form>
    </div>
</body>
</html>