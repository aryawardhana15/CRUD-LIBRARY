<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];

    $query = "UPDATE buku SET judul='$judul', penulis='$penulis', tahun_terbit='$tahun_terbit', genre='$genre' WHERE id=$id";
    mysqli_query($koneksi, $query);

    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM buku WHERE id=$id";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
</head>
<body>
    <h1>Edit Buku</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" value="<?= $row['judul'] ?>" required><br>
        <label for="penulis">Penulis:</label>
        <input type="text" name="penulis" value="<?= $row['penulis'] ?>" required><br>
        <label for="tahun_terbit">Tahun Terbit:</label>
        <input type="number" name="tahun_terbit" value="<?= $row['tahun_terbit'] ?>" required><br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre" value="<?= $row['genre'] ?>" required><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html>