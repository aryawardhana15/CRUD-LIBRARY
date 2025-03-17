<?php
include 'koneksi.php';

// Pagination
$limit = 6; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$query_count = "SELECT COUNT(*) as total FROM buku";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_pages = ceil($total_data / $limit);

// Query untuk mengambil data dengan limit dan offset
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM buku WHERE judul LIKE '%$search%' OR penulis LIKE '%$search%' OR genre LIKE '%$search%' LIMIT $limit OFFSET $offset";
} else {
    $query = "SELECT * FROM buku LIMIT $limit OFFSET $offset";
}
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>perpustakaan Mini</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Daftar Buku</h1>

        <!-- Form Pencarian -->
        <form method="GET" action="" class="mb-6">
            <div class="flex justify-center">
                <input type="text" name="search" placeholder="Cari judul, penulis, atau genre" value="<?= $search ?>"
                       class="w-64 px-4 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Cari
                </button>
            </div>
        </form>

        <!-- Tombol Tambah Buku -->
        <div class="text-right mb-4">
            <a href="tambah.php" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Tambah Buku
            </a>
        </div>

        <!-- Daftar Buku -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Gambar Cover -->
                    <div class="h-48 overflow-hidden">
                        <img src="uploads/<?= $row['cover'] ?>" alt="<?= $row['judul'] ?>" class="w-full h-full object-cover">
                    </div>
                    <!-- Informasi Buku -->
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?= $row['judul'] ?></h2>
                        <p class="text-gray-700 mb-1"><span class="font-semibold">Penulis:</span> <?= $row['penulis'] ?></p>
                        <p class="text-gray-700 mb-1"><span class="font-semibold">Tahun Terbit:</span> <?= $row['tahun_terbit'] ?></p>
                        <p class="text-gray-700 mb-4"><span class="font-semibold">Genre:</span> <?= $row['genre'] ?></p>
                        <!-- Tombol Aksi -->
                        <div class="flex space-x-2">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Edit
                            </a>
                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>


        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&search=<?= $search ?>" class="px-4 py-2 bg-blue-500 text-white rounded-l hover:bg-blue-600">
                    Previous
                </a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= $search ?>" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600 <?= $i == $page ? 'bg-blue-700' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>&search=<?= $search ?>" class="px-4 py-2 bg-blue-500 text-white rounded-r hover:bg-blue-600">
                    Next
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Script Konfirmasi Hapus -->
    <script>
    function confirmDelete(id) {
        if (confirm("Yakin ingin menghapus?")) {
            window.location.href = `hapus.php?id=${id}`;
        }
    }
    </script>
</body>
</html>