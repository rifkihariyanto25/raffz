<?php
$mobil_result = $conn->query("SELECT * FROM mobil");

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
            // Create img directory if it doesn't exist
            $uploadDir = 'img';
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    echo "<script>alert('Gagal membuat direktori upload');</script>";
                    exit;
                }
            }

            // Make sure the directory is writable
            if (!is_writable($uploadDir)) {
                chmod($uploadDir, 0777);
            }

            $newImageName = uniqid() . '.' . $imageExtension;
            $targetPath = $uploadDir . '/' . $newImageName;

            // Try to move the uploaded file
            if (move_uploaded_file($tmpNama, $targetPath)) {
                // Simpan data mobil ke database
                $query = "INSERT INTO mobil (nama_mobil, harga_per_hari, jumlah_unit, foto_mobil, status) 
                         VALUES ('$nama_mobil', '$harga_per_hari', '$jumlah_unit', '$newImageName', '$status')";

                if ($conn->query($query)) {
                    echo "<script>
                        alert('Data berhasil ditambahkan');
                        window.location.href = 'index.php';
                    </script>";
                    exit;
                } else {
                    // If database insert fails, delete the uploaded image
                    unlink($targetPath);
                    echo "<script>alert('Gagal menambahkan data ke database');</script>";
                }
            } else {
                $error = error_get_last();
                echo "<script>alert('Gagal mengunggah gambar: " . addslashes($error['message']) . "');</script>";
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

    $foto_mobil = $existing_foto;
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

?>

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
                        <button type="button" class="btn-view" data-id="<?= $mobil['id_mobil'] ?>">
                            <i class="fas fa-eye"></i>
                        </button>
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


<!-- tambah mobil -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Data Mobil</h2>
            <span class="close">&times;</span>
        </div>
        <form id="addForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_mobil">Nama Mobil:</label>
                <input type="text" id="nama_mobil" name="nama_mobil" required>
            </div>

            <div class="form-group">
                <label for="harga_per_hari">Harga Sewa per Hari:</label>
                <input type="number" id="harga_per_hari" name="harga_per_hari" required>
            </div>

            <div class="form-group">
                <label for="jumlah_unit">Jumlah Unit:</label>
                <input type="number" id="jumlah_unit" name="jumlah_unit" required>
            </div>

            <div class="form-group">
                <label for="foto_mobil">Foto Mobil:</label>
                <input type="file" id="foto_mobil" name="foto_mobil" required>
                <small>Format: jpg, jpeg, png (Max. 5MB)</small>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="tersedia">Tersedia</option>
                    <option value="tidak tersedia">Tidak Tersedia</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel">Batal</button>
                <button type="submit" name="add_mobil" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addModal = document.getElementById('addModal');
            const addBtn = document.querySelector('.btn-tambah');
            const closeAddBtn = addModal.querySelector('.close');
            const cancelAddBtn = addModal.querySelector('.btn-cancel');
            const addForm = document.getElementById('addForm');

            // Open modal when clicking add button
            addBtn.addEventListener('click', function() {
                addModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });

            // Close modal functions
            function closeAddModal() {
                addModal.style.display = 'none';
                document.body.style.overflow = 'auto';
                addForm.reset(); // Reset form when closing
            }

            // Close modal event listeners
            closeAddBtn.addEventListener('click', closeAddModal);
            cancelAddBtn.addEventListener('click', closeAddModal);

            // Close when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === addModal) {
                    closeAddModal();
                }
            });

            // Close on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && addModal.style.display === 'block') {
                    closeAddModal();
                }
            });

            // File input validation
            const fotoMobil = document.getElementById('foto_mobil');
            fotoMobil.addEventListener('change', function() {
                const file = this.files[0];
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                const validExtensions = ['jpg', 'jpeg', 'png'];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (!validExtensions.includes(fileExtension)) {
                    alert('Format gambar tidak valid (harus jpg, jpeg, png)');
                    this.value = '';
                } else if (fileSize > 5) {
                    alert('Ukuran gambar terlalu besar (maksimal 5MB)');
                    this.value = '';
                }
            });
        });
    </script>
</div>

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
            const deleteCarModal = document.getElementById('deleteCarModal');
            const deleteCarButtons = document.querySelectorAll('.btn-delete');
            const closeCarDeleteBtn = document.querySelector('#deleteCarModal .close-delete');
            const cancelCarDeleteBtn = document.querySelector('#deleteCarModal .btn-cancel-delete');
            const deleteCarIdInput = document.getElementById('carIdToDelete');

            function openDeleteCarModal(carId) {
                deleteCarIdInput.value = carId;
                deleteCarModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeDeleteCarModal() {
                deleteCarModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            deleteCarButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const carId = this.getAttribute('data-id');
                    openDeleteCarModal(carId);
                });
            });

            closeCarDeleteBtn.addEventListener('click', closeDeleteCarModal);
            cancelCarDeleteBtn.addEventListener('click', closeDeleteCarModal);

            window.addEventListener('click', function(event) {
                if (event.target === deleteCarModal) {
                    closeDeleteCarModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && deleteCarModal.style.display === 'block') {
                    closeDeleteCarModal();
                }
            });
        });
    </script>
</div>

<!-- view mobil -->

</div>
</div>