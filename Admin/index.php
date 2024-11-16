<?php
session_start();
include '../config/config.php';

$mobil_result = $conn->query("SELECT * FROM mobil");
$sopir_result = $conn->query("SELECT * FROM sopir");


// Penambahan mobil
if (isset($_POST['add_mobil'])) {
  $id_mobil = isset($_POST['id_mobil']);
  $nama_mobil = $conn->real_escape_string($_POST['nama_mobil']);
  $harga_per_hari = $conn->real_escape_string($_POST['harga_per_hari']);
  $jumlah_unit = $conn->real_escape_string($_POST['jumlah_unit']);
  $status = $_POST['status'];

  // Validasi file gambar
  if ($_FILES["foto_mobil"]["error"] === 4) {
    echo "<script>alert('Gambar tidak diunggah');</script>";
  } else {
    $filename = $_FILES["foto_mobil"]["name"];
    $filesize = $_FILES["foto_mobil"]["size"];
    $tmpNama = $_FILES["foto_mobil"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($imageExtension, $validImageExtension)) {
      echo "<script>alert('Format gambar tidak valid (harus jpg, jpeg, png)');</script>";
    } else if ($filesize > 5000000) { // 5MB
      echo "<script>alert('Ukuran gambar terlalu besar (maksimal 5MB)');</script>";
    } else {
      $newImageName = uniqid() . '.' . $imageExtension;
      $targetDir = 'img/' . $newImageName;
      if (move_uploaded_file($tmpNama, $targetDir)) {
        // Simpan data mobil ke database
        $query = "INSERT INTO mobil (nama_mobil, harga_per_hari, jumlah_unit, foto_mobil, status) 
         VALUES ('$nama_mobil', '$harga_per_hari', '$jumlah_unit', '$newImageName', '$status')";

        if ($conn->query($query)) {
          header("Location: index.php");
          exit;
        } else {
          echo "<script>alert('Gagal menambahkan data ke database');</script>";
        }
      } else {
        echo "<script>alert('Gagal mengunggah gambar');</script>";
      }
    }
  }
}


// Menangani pembaruan mobil
if (isset($_POST['update_mobil'])) {
  $id_mobil = $_POST['id_mobil'];
  $nama_mobil = $conn->real_escape_string($_POST['nama_mobil']);
  $harga_per_hari = $conn->real_escape_string(str_replace(['Rp', '.', ','], '', $_POST['harga_per_hari']));
  $jumlah_unit = $conn->real_escape_string($_POST['jumlah_unit']);
  $status = $_POST['status'];
  $existing_foto = $_POST['existing_foto'];

  $foto_mobil = $existing_foto; // Default to existing photo

  // Check if new image is uploaded
  if (isset($_FILES['foto_mobil']) && $_FILES['foto_mobil']['size'] > 0) {
    $filename = $_FILES['foto_mobil']['name'];
    $filesize = $_FILES['foto_mobil']['size'];
    $tmpNama = $_FILES['foto_mobil']['tmp_name'];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($imageExtension, $validImageExtension)) {
      echo "<script>alert('Format gambar tidak valid (harus jpg, jpeg, png)'); window.location.href = 'index.php';</script>";
      exit;
    }

    if ($filesize > 5000000) { // 5MB
      echo "<script>alert('Ukuran gambar terlalu besar (maksimal 5MB)'); window.location.href = 'index.php';</script>";
      exit;
    }

    // Generate new image name
    $foto_mobil = uniqid() . '.' . $imageExtension;
    $targetDir = 'img/' . $foto_mobil;

    // Upload new image
    if (!move_uploaded_file($tmpNama, $targetDir)) {
      echo "<script>alert('Gagal mengunggah gambar baru'); window.location.href = 'index.php';</script>";
      exit;
    }

    // Delete old image if exists and different from default
    if ($existing_foto && file_exists('img/' . $existing_foto)) {
      unlink('img/' . $existing_foto);
    }
  }

  // Update database
  $query = "UPDATE mobil SET 
              nama_mobil = ?,
              harga_per_hari = ?,
              jumlah_unit = ?,
              foto_mobil = ?,
              status = ?
              WHERE id_mobil = ?";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssssi", $nama_mobil, $harga_per_hari, $jumlah_unit, $foto_mobil, $status, $id_mobil);

  if ($stmt->execute()) {
    echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = 'index.php';
              </script>";
  } else {
    echo "<script>
                alert('Gagal mengupdate data: " . $conn->error . "');
                window.location.href = 'index.php';
              </script>";
  }

  $stmt->close();
}


// Menangani penghapusan mobil
if (isset($_POST['delete_mobil'])) {
  $id_mobil = $_POST['id_mobil'];

  $stmt = $conn->prepare("DELETE FROM mobil WHERE id_mobil = ?");
  if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
  }
  $stmt->bind_param("i", $id_mobil);
  if ($stmt->execute()) {
    header("Location: index.php");
    exit;
  } else {
    echo "Gagal menghapus data: " . $stmt->error;
  }
  $stmt->close();
}


// penambahan sopir
if (isset($_POST['add_sopir'])) {
  // $id = $conn->real_escape_string($_POST['id']);
  $nama_sopir = $conn->real_escape_string($_POST['nama_sopir']);
  $alamat_sopir = $conn->real_escape_string($_POST['alamat_sopir']);
  $sim_sopir = $conn->real_escape_string($_POST['sim_sopir']);

  if (!$conn->query("INSERT INTO sopir (nama_sopir, alamat_sopir, sim_sopir) VALUES ('$nama_sopir', '$alamat_sopir', '$sim_sopir')")) {
    echo "Error: " . $conn->error;
  }
  header("Location: index.php");
  exit(); // Tambahkan exit setelah redirect
}
?>





<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RAFZZ Car - Admin Pages</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="script.js" />
  <!-- Link Font Awesome dari CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- atau versi terbaru -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    /* Add these styles to your CSS file */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px;
      border-radius: 8px;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .close {
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .modal-footer {
      margin-top: 20px;
      text-align: right;
    }

    .btn-save {
      background-color: #4CAF50;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 10px;
    }

    .btn-cancel {
      background-color: #f44336;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .form-group small {
      display: block;
      margin-top: 5px;
      color: #666;
    }

    .form-group input[type="file"] {
      padding: 10px 0;
    }

    #current_image {
      border: 1px solid #ddd;
      padding: 5px;
      border-radius: 4px;
    }

    /* Style untuk custom file input */
    .form-group input[type="file"]::file-selector-button {
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      margin-right: 10px;
    }

    .form-group input[type="file"]::file-selector-button:hover {
      background-color: #45a049;
    }


    /* Modal delete styles dengan class yang berbeda */
    .modal-delete {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }

    .modal-delete-content {
      position: relative;
      background-color: #fff;
      margin: 15% auto;
      padding: 0;
      width: 90%;
      max-width: 500px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      animation: modalDeleteSlide 0.3s ease-out;
    }

    @keyframes modalDeleteSlide {
      from {
        transform: translateY(-100px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .modal-delete-header {
      padding: 15px 20px;
      border-bottom: 1px solid #e5e5e5;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-delete-header h2 {
      margin: 0;
      font-size: 1.25rem;
      color: #333;
    }

    .close-delete {
      font-size: 28px;
      font-weight: bold;
      color: #666;
      cursor: pointer;
      transition: color 0.2s;
    }

    .close-delete:hover {
      color: #333;
    }

    .modal-delete-body {
      padding: 20px;
    }

    .modal-delete-footer {
      padding: 15px 20px;
      border-top: 1px solid #e5e5e5;
      text-align: right;
    }

    /* Button styles untuk delete */
    .btn-cancel-delete {
      background-color: #6c757d;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 10px;
      transition: background-color 0.2s;
    }

    .btn-cancel-delete:hover {
      background-color: #5a6268;
    }

    .btn-confirm-delete {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .btn-confirm-delete:hover {
      background-color: #c82333;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="logo">RAFZZ Car</div>

      <p class="Right">Admin</p>

      <div class="menu-item">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </div>
      <div class="menu-item">
        <i class="fas fa-car"></i>
        <span>Mobil</span>
      </div>
      <div class="menu-item">
        <i class="fas fa-users"></i>
        <span>Sopir</span>
      </div>
      <div class="menu-item">
        <i class="fas fa-calendar-check"></i>
        <span>Booking</span>
      </div>
      <div class="menu-item">
        <i class="fas fa-cog"></i>
        <span>Pengaturan</span>
      </div>
      <div class="menu-item">
        <i class="fas fa-comment"></i>
        <span>Pesan</span>
      </div>
    </div>

    <!-- Dashboard Page -->
    <div class="main-content" id="dashboardPage">
      <div class="header">
        <h2>Dashboard</h2>
        <select class="admin-dropdown">
          <option>admin01</option>
        </select>
      </div>

      <div class="dashboard-cards">
        <div class="card">
          <div class="card-title">Total Transaksi</div>
          <div class="card-value">35</div>
        </div>
        <div class="card">
          <div class="card-title">Mobil Tersedia</div>
          <div class="card-value">10</div>
        </div>
        <div class="card">
          <div class="card-title">Sopir Tersedia</div>
          <div class="card-value">15</div>
        </div>
      </div>

      <div class="table-container">
        <div class="table-header">
          <div class="table-title">Mobil yang Tersedia</div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Mobil</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Toyota Xpander</td>
              <td>1</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Toyota Alphard</td>
              <td>1</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Daihatsu Ayla</td>
              <td>4</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Daihatsu Xenia</td>
              <td>3</td>
            </tr>
            <tr>
              <td>5</td>
              <td>Hyundai Palisade</td>
              <td>1</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Mobil Page -->
    <div class="main-content" id="mobilPage" style="display: none">
      <div class="header">
        <h2>Data Mobil</h2>
        <select class="admin-dropdown">
          <option>admin01</option>
        </select>
      </div>

      <div class="table-container">
        <div class="table-header">
          <div class="table-title">Data Mobil</div>
          <button class="btn-tambah"><i class="fas fa-plus"></i> Tambah</button>
        </div>

        <div class="table-controls">
          <div class="entries-control">
            Show
            <select>
              <option>5</option>
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
            entries
          </div>
          <div class="search-control">Search: <input type="text" placeholder="Cari..." /></div>
        </div>

        <!-- daftar mobil -->
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Gambar Mobil</th>
              <th>Harga Sewa</th>
              <th>Jumlah Unit</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $nomor = 1;
            while ($mobil = $mobil_result->fetch_assoc()):
              $imagePath = htmlspecialchars('img/' . $mobil['foto_mobil']);
            ?>
              <tr data-id="<?= $mobil['id_mobil'] ?>">
                <td><?= $nomor++ ?></td>
                <td><?= htmlspecialchars($mobil['nama_mobil']) ?></td>
                <td>
                  <?php if (!empty($mobil['foto_mobil'])): ?>
                    <img src="<?= htmlspecialchars('img/' . $mobil['foto_mobil']) ?>" class="car-image" alt="Car Image" style="width: 100px; height: auto;">
                  <?php else: ?>
                    <span>tidak ada gambar</span>
                  <?php endif; ?>
                </td>
                <td>
                  <span>Rp <?= number_format($mobil['harga_per_hari'], 0, ',', '.') ?></span>
                </td>
                <td>
                  <span><?= htmlspecialchars($mobil['jumlah_unit']) ?></span>
                </td>
                <td>
                  <select name="status" disabled>
                    <option value="tersedia" <?= $mobil['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="tidak tersedia" <?= $mobil['status'] == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                  </select>
                </td>
                <td class="action-buttons">
                  <button type="button" class="btn-edit">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" class="btn-delete" data-id="<?= $mobil['id_mobil'] ?>">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              </tr>
            <?php endwhile; ?>
            <!-- Additional car rows similar to your image -->
          </tbody>
        </table>
      </div>
      <!-- Add this modal HTML right before the closing body tag -->
      <!-- edit mobil -->
      <div id="editModal" class="modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Edit Data Mobil</h2>
            <span class="close">&times;</span>
          </div>
          <form id="editForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit_id_mobil" name="id_mobil">

            <div class="form-group">
              <label for="edit_nama_mobil">Nama Mobil:</label>
              <input type="text" id="edit_nama_mobil" name="nama_mobil" required>
            </div>

            <div class="form-group">
              <label for="edit_harga_per_hari">Harga Sewa per Hari:</label>
              <input type="number" id="edit_harga_per_hari" name="harga_per_hari" required>
            </div>

            <div class="form-group">
              <label for="edit_jumlah_unit">Jumlah Unit:</label>
              <input type="number" id="edit_jumlah_unit" name="jumlah_unit" required>
            </div>

            <div class="form-group">
              <label for="edit_foto_mobil">Foto Mobil:</label>
              <input type="file" id="edit_foto_mobil" name="foto_mobil">
              <img id="current_image" src="" alt="Current Image" style="max-width: 200px; display: none;">
              <input type="hidden" id="existing_foto" name="existing_foto">
            </div>

            <div class="form-group">
              <label for="edit_status">Status:</label>
              <select id="edit_status" name="status" required>
                <option value="tersedia">Tersedia</option>
                <option value="tidak tersedia">Tidak Tersedia</option>
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-cancel">Batal</button>
              <button type="submit" name="update_mobil" class="btn-save">Simpan Perubahan</button>
            </div>
          </form>
        </div>


        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editModal');
            const span = document.getElementsByClassName('close')[0];
            const cancelBtn = modal.querySelector('.btn-cancel');

            // Function to open modal and populate data
            function openEditModal(carData) {
              console.log('Car Data:', carData); // Debugging
              document.getElementById('edit_id_mobil').value = carData.id_mobil;
              document.getElementById('edit_nama_mobil').value = carData.nama_mobil;
              document.getElementById('edit_harga_per_hari').value = carData.harga_per_hari.replace(/[^\d]/g, ''); // Remove non-digits
              document.getElementById('edit_jumlah_unit').value = carData.jumlah_unit;
              document.getElementById('edit_status').value = carData.status;
              document.getElementById('existing_foto').value = carData.foto_mobil;

              const currentImage = document.getElementById('current_image');
              if (carData.foto_mobil) {
                currentImage.src = 'img/' + carData.foto_mobil;
                currentImage.style.display = 'block';
              } else {
                currentImage.style.display = 'none';
              }

              modal.style.display = 'block';
            }

            // Add click event to all edit buttons
            document.querySelectorAll('.btn-edit').forEach(button => {
              button.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const carData = {
                  id_mobil: row.getAttribute('data-id'),
                  nama_mobil: row.cells[1].textContent.trim(),
                  harga_per_hari: row.cells[3].querySelector('span').textContent.trim(),
                  jumlah_unit: row.cells[4].querySelector('span').textContent.trim(),
                  status: row.cells[5].querySelector('select').value,
                  foto_mobil: row.cells[2].querySelector('img') ?
                    row.cells[2].querySelector('img').src.split('/').pop() : ''
                };
                console.log('Extracted Car Data:', carData); // Debugging
                openEditModal(carData);
              });
            });

            // Close modal when clicking (X)
            span.onclick = function() {
              modal.style.display = 'none';
            }

            // Close modal when clicking cancel button
            cancelBtn.onclick = function() {
              modal.style.display = 'none';
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
              if (event.target == modal) {
                modal.style.display = 'none';
              }
            }
          });
        </script>
      </div>

      <!-- hapus mobilL -->
      <div id="deleteCarModal" class="modal-delete">
        <div class="modal-delete-content">
          <div class="modal-delete-header">
            <h2>Konfirmasi Hapus</h2>
            <span class="close-delete">&times;</span>
          </div>
          <div class="modal-delete-body">
            <p>Apakah Anda yakin ingin menghapus data mobil ini?</p>
          </div>
          <div class="modal-delete-footer">
            <form id="deleteCarForm" method="POST">
              <input type="hidden" name="id_mobil" id="carIdToDelete">
              <button type="button" class="btn-cancel-delete">Batal</button>
              <button type="submit" name="delete_mobil" class="btn-confirm-delete">Hapus</button>
            </form>
          </div>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteCarModal');
            const deleteButtons = document.querySelectorAll('.btn-delete');
            const closeDeleteBtn = document.querySelector('.close-delete');
            const cancelDeleteBtn = document.querySelector('.btn-cancel-delete');
            const deleteCarIdInput = document.getElementById('carIdToDelete');

            // Fungsi untuk membuka modal delete
            function openDeleteModal(carId) {
              deleteCarIdInput.value = carId;
              deleteModal.style.display = 'block';
              document.body.style.overflow = 'hidden';
            }

            // Fungsi untuk menutup modal delete
            function closeDeleteModal() {
              deleteModal.style.display = 'none';
              document.body.style.overflow = 'auto';
            }

            // Event listener untuk tombol delete
            deleteButtons.forEach(button => {
              button.addEventListener('click', function() {
                const carId = this.getAttribute('data-id');
                openDeleteModal(carId);
              });
            });

            // Event listener untuk tombol close delete
            closeDeleteBtn.addEventListener('click', closeDeleteModal);
            cancelDeleteBtn.addEventListener('click', closeDeleteModal);

            // Menutup modal delete ketika mengklik di luar modal
            window.addEventListener('click', function(event) {
              if (event.target === deleteModal) {
                closeDeleteModal();
              }
            });

            // Menutup modal delete dengan tombol ESC
            document.addEventListener('keydown', function(event) {
              if (event.key === 'Escape' && deleteModal.style.display === 'block') {
                closeDeleteModal();
              }
            });
          });
        </script>
      </div>

    </div>



    <!-- Page Content - Sopir -->
    <div class="main-content" id="sopirPage">
      <div class="header">
        <h2>Data Sopir</h2>
        <select class="admin-dropdown">
          <option>admin01</option>
        </select>
      </div>

      <div class="table-container">
        <div class="table-header">
          <div class="table-title">Data Sopir</div>
          <button class="btn-tambah"><i class="fas fa-plus"></i> Tambah</button>
        </div>

        <div class="table-controls">
          <div class="entries-control">
            Show
            <select>
              <option>5</option>
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
            entries
          </div>
          <div class="search-control">Search: <input type="text" placeholder="Cari..." /></div>
        </div>

        <!-- daftar sopir -->

        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Alamat</th>
              <th>Foto SIM A</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Sample data rows -->
            <?php
            $nomor = 1;
            while ($sopir = $sopir_result->fetch_assoc()): ?>
              <tr>
                <td><?= $nomor++ ?></td>
                <td><?= htmlspecialchars($sopir['nama_sopir']) ?></td>
                <td><?= htmlspecialchars($sopir['alamat_sopir']) ?></td>
                <td><?= htmlspecialchars($sopir['sim_sopir']) ?></td>
                <!-- <td>
                  <select name="status">
                    <option value="tersedia" <?= $mobil['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="tidak tersedia" <?= $mobil['status'] == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                  </select>
                </td> -->
                <td class="action-buttons">
                  <button type="submit" name="update_mobil" class="btn-edit"><i class="fas fa-edit"></i> Ubah</button>
                  <button type="submit" name="delete_mobil" class="btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                </td>
              </tr>
            <?php endwhile; ?>

            <!-- Repeat for 5 rows -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Page Content - Booking -->
    <div class="main-content" id="bookingPage" style="display: none">
      <div class="header">
        <h2>Data Booking</h2>
        <select class="admin-dropdown">
          <option>admin01</option>
        </select>
      </div>

      <div class="table-container">
        <div class="table-header">
          <div class="table-title">Data Booking</div>
        </div>

        <div class="table-controls">
          <div class="entries-control">
            Show
            <select>
              <option>5</option>
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
            entries
          </div>
          <div class="search-control">Search: <input type="text" placeholder="Cari..." /></div>
        </div>

        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Alamat</th>
              <th>No. WhatsApp</th>
              <th>Mobil</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Sample data rows -->
            <tr>
              <td>1</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="action-buttons">
                <button class="btn-edit"><i class="fas fa-edit"></i></button>
                <button class="btn-delete"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <!-- Repeat for 5 rows -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Page Content - Pengaturan -->
    <div class="main-content" id="pengaturanPage" style="display: none">
      <div class="header">
        <h2>Edit Data</h2>
        <select class="admin-dropdown">
          <option>admin01</option>
        </select>
      </div>

      <div class="form-container">
        <form>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" />
          </div>
          <div class="form-group">
            <label for="nomorPerusahaan">Nomor Perusahaan</label>
            <input type="text" id="nomorPerusahaan" name="nomorPerusahaan" />
          </div>
          <div class="form-group">
            <label for="tentangPerusahaan">Tentang Perusahaan</label>
            <textarea id="tentangPerusahaan" name="tentangPerusahaan" rows="4"></textarea>
          </div>
          <button type="submit" class="btn-simpan">Simpan</button>
        </form>
      </div>
    </div>
    <!-- New Messages Page -->
    <div class="main-content" id="pesanPage" style="display: none">
      <div class="header">
        <h2>Data Booking</h2>
        <select class="admin-dropdown">
          <option>admin01</option>
        </select>
      </div>

      <div class="table-container">
        <div class="table-header">
          <div class="table-title">Data Booking</div>
        </div>

        <div class="table-controls">
          <div class="entries-control">
            Show
            <select>
              <option>5</option>
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
            entries
          </div>
          <div class="search-control">Search: <input type="text" placeholder="Cari..." /></div>
        </div>

        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>Pesan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="action-buttons">
                <button class="btn-delete"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="action-buttons">
                <button class="btn-delete"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="action-buttons">
                <button class="btn-delete"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>4</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="action-buttons">
                <button class="btn-delete"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>5</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="action-buttons">
                <button class="btn-delete"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
  <!DOCTYPE html>
  <html lang="id">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      .form-page {
        display: none;
        position: fixed;
        top: 0;
        left: 250px;
        right: 0;
        bottom: 0;
        background: #f4f4f4;
        padding: 20px;
        z-index: 1000;
      }

      .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 15px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .header-content {
        display: flex;
        align-items: center;
        gap: 20px;
      }

      .btn-kembali {
        background-color: #ff6b4a;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .form-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .form-group {
        margin-bottom: 20px;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
      }

      .form-group input,
      .form-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
      }

      .btn-simpan {
        background-color: #ff6b4a;
        color: white;
        border: none;
        padding: 8px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 10px;
      }

      .form-title {
        font-size: 18px;
        font-weight: 500;
      }

      .admin-select {
        color: #666;
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
      }

      .file-input-container {
        position: relative;
      }

      .file-input-label {
        display: inline-block;
        padding: 8px 12px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        color: #666;
      }

      .file-input {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
      }

      .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
      }
    </style>
  </head>

  <body>
    <div class="form-page" id="tambahMobilPage">
      <div class="form-header">
        <div class="form-title">Tambah Data</div>
        <div class="header-right">
          <select class="admin-select">
            <option>admin01</option>
          </select>
          <button class="btn-kembali" id="btnKembali">← Kembali</button>
        </div>
      </div>

      <!-- Form HTML untuk tambah data mobil -->
      <div class="form-container">

        <form id="addCarForm" method="post" enctype="multipart/form-data">

          <div class="form-group">
            <label for="fotoMobil">Upload Foto</label>
            <input type="file" name="foto_mobil" id="fotoMobil" accept=".png, .jpeg, .png">
          </div>

          <div class="form-group">
            <label for="namaMobil">Nama Mobil</label>
            <input type="text" name="nama_mobil" id="namaMobil" required>
          </div>

          <div class="form-group">
            <label for="hargaSewa">Harga Sewa</label>
            <input type="number" name="harga_per_hari" id="hargaSewa" required>
          </div>

          <div class="form-group">
            <label for="jumlahUnit">Jumlah Unit</label>
            <input type="number" name="jumlah_unit" id="jumlahUnit" required>
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="tersedia">Tersedia</option>
              <option value="tidak tersedia">Tidak Tersedia</option>
            </select>
          </div>

          <button type="submit" name="add_mobil" class="btn-simpan">Simpan</button>
        </form>
      </div>

      <script>
        // Handle back button click
        document.getElementById('btnKembali').addEventListener('click', function() {
          document.getElementById('tambahMobilPage').style.display = 'none';
          document.getElementById('mobilPage').style.display = 'block';
        });
        // Update file input label when file is selected
        // document.getElementById('gambarMobil').addEventListener('change', function(e) {
        //   const fileName = e.target.files[0]?.name || 'Pilih File';
        //   e.target.previousElementSibling.textContent = fileName;
        // });
      </script>

      <!DOCTYPE html>
      <html lang="id">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
          .form-page {
            display: none;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            bottom: 0;
            background: #f4f4f4;
            padding: 20px;
            z-index: 1000;
          }

          .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
          }

          .header-content {
            display: flex;
            align-items: center;
            gap: 20px;
          }

          .btn-kembali {
            background-color: #ff6b4a;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
          }

          .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
          }

          .form-group {
            margin-bottom: 20px;
          }

          .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
          }

          .form-group input,
          .form-group select,
          .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
          }

          .btn-simpan {
            background-color: #ff6b4a;
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
          }

          .form-title {
            font-size: 18px;
            font-weight: 500;
          }

          .admin-select {
            color: #666;
            padding: 4px 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
          }

          .file-input-container {
            position: relative;
          }

          .file-input-label {
            display: inline-block;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            color: #666;
          }

          .file-input {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
          }

          .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
          }
        </style>
      </head>

      <body>
        <div class="form-page" id="tambahSopirPage">
          <div class="form-header">
            <div class="form-title">Tambah Data</div>
            <div class="header-right">
              <select class="admin-select">
                <option>admin01</option>
              </select>
              <button class="btn-kembali" id="btnKembaliSopir">← Kembali</button>
            </div>
          </div>

          <div class="form-container">
            <form id="addDriverForm">
              <div class="form-group">
                <label for="namaLengkap">Nama Lengkap</label>
                <input type="text" id="namaLengkap" name="namaLengkap" required>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" required></textarea>
              </div>

              <div class="form-group">
                <label for="fotoSIM">Foto SIM A</label>
                <div class="file-input-container">
                  <label class="file-input-label">Pilih File</label>
                  <input type="file" id="fotoSIM" name="fotoSIM" class="file-input" accept="image/*" required>
                </div>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Non-Aktif</option>
                </select>
              </div>

              <button type="submit" class="btn-simpan">Simpan</button>
            </form>
          </div>
        </div>

        <script>
          // Show add driver form when "Tambah" button is clicked in driver page
          document.querySelector('#sopirPage .btn-tambah').addEventListener('click', function() {
            document.getElementById('tambahSopirPage').style.display = 'block';
            document.getElementById('sopirPage').style.display = 'none';
          });

          // Handle back button click
          document.getElementById('btnKembaliSopir').addEventListener('click', function() {
            document.getElementById('tambahSopirPage').style.display = 'none';
            document.getElementById('sopirPage').style.display = 'block';
          });

          // Handle form submission
          document.getElementById('addDriverForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here

            // Hide form and show driver list page
            document.getElementById('tambahSopirPage').style.display = 'none';
            document.getElementById('sopirPage').style.display = 'block';
          });

          // Update file input label when file is selected
          document.getElementById('fotoSIM').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Pilih File';
            e.target.previousElementSibling.textContent = fileName;
          });
        </script>
      </body>

      </html>
  </body>

  </html>