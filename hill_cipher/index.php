<?php
include "koneksi.php";
include "hillchiper.php";

$keyMatrix = [[2,1],[3,4]];

// Create
if (isset($_POST['create'])) {
    $nama_nasabah = $_POST['nama_nasabah'];
    $nama_terenkripsi = encryptHillCipher($nama_nasabah, $keyMatrix);
    $sql = "INSERT INTO data_nasabah (nama_nasabah, nama_terenkripsi) VALUES ('$nama_nasabah', '$nama_terenkripsi')";
    mysqli_query($conn, $sql);
}

// Read
$sql = "SELECT * FROM data_nasabah";
$result = mysqli_query($conn, $sql);

// Update
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama_nasabah = $_POST['nama_nasabah'];
    $nama_terenkripsi = encryptHillCipher($nama_nasabah, $keyMatrix);
    $sql = "UPDATE data_nasabah SET nama_nasabah='$nama_nasabah', nama_terenkripsi='$nama_terenkripsi' WHERE id=$id";
    mysqli_query($conn, $sql);
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM data_nasabah WHERE id=$id";
    mysqli_query($conn, $sql);
}

if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $newNamaNasabah = $_POST['nama_nasabah'];
    
    // Mengambil nama terenkripsi dari database
    $sql = "SELECT nama_terenkripsi FROM data_nasabah WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $nama_terenkripsi = $row['nama_terenkripsi'];
        
        // Cek apakah nama nasabah berubah
        if ($newNamaNasabah !== decryptHillCipher($nama_terenkripsi, $keyMatrix)) {
            $nama_terenkripsi = encryptHillCipher($newNamaNasabah, $keyMatrix);
        }

        // Update data nasabah dengan nama nasabah yang baru dan nama terenkripsi yang diubah atau tidak
        $sql = "UPDATE data_nasabah SET nama_nasabah='$newNamaNasabah', nama_terenkripsi='$nama_terenkripsi' WHERE id=$id";
        mysqli_query($conn, $sql);
    }
}



?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD dengan Enkripsi Hill Cipher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
            transition: background-color 0.3s;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 5px;
        }

        button {
            padding: 5px 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        a {
            text-decoration: none;
            padding: 3px 6px;
            background-color: #333;
            color: white;
        }

        a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Data Nasabah</h2>
    <form method="post">
        <input type="text" name="nama_nasabah" placeholder="Nama Nasabah" required>
        <button type="submit" name="create">Tambah</button>
    </form>
    <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Nasabah</th>
            <th>Nama Terenkripsi</th>
            <th>Nama Terdeskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $nama_nasabah = $row['nama_nasabah'];
            $nama_terenkripsi = $row['nama_terenkripsi'];
            $nama_terdeskripsi = decryptHillCipher($nama_terenkripsi, $keyMatrix);
            echo "<tr>";
                echo "<td>$id</td>";
                echo "<td>$nama_nasabah</td>";
                echo "<td>$nama_terenkripsi</td>";
                echo "<td>$nama_nasabah</td>";
                echo "<td><a href='index.php?delete=$id'>Hapus</a></td>";
                echo "<td><a href='index.php?edit=$id'>Edit</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
