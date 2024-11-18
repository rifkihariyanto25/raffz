<?php
$sopir_result = $conn->query("SELECT * FROM sopir");

// Penambahan sopir
if (isset($_POST['add_sopir'])) {
    $nama_sopir = $conn->real_escape_string($_POST['nama_sopir']);
    $alamat_sopir = $conn->real_escape_string($_POST['alamat_sopir']);
    $status_sopir = $_POST['status_sopir'];

    // Validasi file SIM
    if ($_FILES["sim_sopir"]["error"] === 4) {
        echo "<script>alert('Foto SIM tidak diunggah');</script>";
    } else {
        $filename = $_FILES["sim_sopir"]["name"];
        $filesize = $_FILES["sim_sopir"]["size"];
        $tmpNama = $_FILES["sim_sopir"]["tmp_name"];

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
                // Simpan data sopir ke database
                $query = "INSERT INTO sopir (nama_sopir, alamat_sopir, sim_sopir, status_sopir) 
                         VALUES ('$nama_sopir', '$alamat_sopir', '$newImageName', '$status_sopir')";

                if ($conn->query($query)) {
                    echo "<script>
                        alert('Data sopir berhasil ditambahkan');
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

// Menangani pembaruan sopir
if (isset($_POST['update_sopir'])) {
    $id_sopir = $_POST['id_sopir'];
    $nama_sopir = $conn->real_escape_string($_POST['nama_sopir']);
    $alamat_sopir = $conn->real_escape_string($_POST['alamat_sopir']);
    $status_sopir = $_POST['status_sopir'];
    $existing_sim = $_POST['existing_sim'];

    $sim_sopir = $existing_sim;
    if (isset($_FILES['sim_sopir']) && $_FILES['sim_sopir']['size'] > 0) {
        $filename = $_FILES['sim_sopir']['name'];
        $filesize = $_FILES['sim_sopir']['size'];
        $tmpNama = $_FILES['sim_sopir']['tmp_name'];

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
        $sim_sopir = uniqid() . '.' . $imageExtension;
        $targetDir = 'img/' . $sim_sopir;

        // Upload new image
        if (!move_uploaded_file($tmpNama, $targetDir)) {
            echo "<script>alert('Gagal mengunggah gambar baru'); window.location.href = 'index.php';</script>";
            exit;
        }

        // Delete old image if exists
        if ($existing_sim && file_exists('img/' . $existing_sim)) {
            unlink('img/' . $existing_sim);
        }
    }

    // Update database
    $query = "UPDATE sopir SET 
                nama_sopir = ?,
                alamat_sopir = ?,
                sim_sopir = ?,
                status_sopir = ?
                WHERE id_sopir = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $nama_sopir, $alamat_sopir, $sim_sopir, $status_sopir, $id_sopir);

    if ($stmt->execute()) {
        echo "<script>
                  alert('Data sopir berhasil diupdate');
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

// Menangani penghapusan sopir
// Menangani penghapusan sopir
if (isset($_POST['delete_sopir'])) {
    $id_sopir = $_POST['id_sopir'];

    try {
        // Get the image filename before deleting the record
        $stmt = $conn->prepare("SELECT sim_sopir FROM sopir WHERE id_sopir = ?");
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("i", $id_sopir);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sopir = $result->fetch_assoc();

            // Delete the record from database
            $delete_stmt = $conn->prepare("DELETE FROM sopir WHERE id_sopir = ?");
            if ($delete_stmt === false) {
                throw new Exception("Error preparing delete statement: " . $conn->error);
            }

            $delete_stmt->bind_param("i", $id_sopir);

            if ($delete_stmt->execute()) {
                // If database deletion successful, delete the image file
                if ($sopir['sim_sopir'] && file_exists('img/' . $sopir['sim_sopir'])) {
                    unlink('img/' . $sopir['sim_sopir']);
                }

                echo "<script>
                    alert('Data sopir berhasil dihapus');
                    window.location.href = 'index.php';
                </script>";
                exit;
            } else {
                throw new Exception("Gagal menghapus data: " . $delete_stmt->error);
            }
            $delete_stmt->close();
        } else {
            throw new Exception("Data sopir tidak ditemukan");
        }
    } catch (Exception $e) {
        echo "<script>
            alert('Error: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
        </script>";
    }

    $stmt->close();
}

?>

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
            <?php
            $nomor = 1;
            while ($sopir = $sopir_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= htmlspecialchars($sopir['nama_sopir']) ?></td>
                    <td><?= htmlspecialchars($sopir['alamat_sopir']) ?></td>
                    <td><?= htmlspecialchars($sopir['sim_sopir']) ?></td>
                    <td>
                        <select name="status_sopir">
                            <option value="tersedia" <?= $sopir['status_sopir'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="tidak tersedia" <?= $sopir['status_sopir'] == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                        </select>
                    </td>
                    <td class="action-buttons">
                        <button type="submit" name="update_sopir" class="btn-edit"><i class="fas fa-edit"></i></button>
                        <button type="submit" name="delete_sopir" class="btn-delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endwhile; ?>

            <!-- Repeat for 5 rows -->
        </tbody>
    </table>
</div>
</div>

<!-- Modal Tambah Sopir -->
<div id="addSopirModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Data Sopir</h2>
            <span class="close">&times;</span>
        </div>
        <form id="addSopirForm" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_sopir">Nama Lengkap:</label>
                <input type="text" id="nama_sopir" name="nama_sopir" required>
            </div>

            <div class="form-group">
                <label for="alamat_sopir">Alamat:</label>
                <textarea id="alamat_sopir" name="alamat_sopir" required></textarea>
            </div>

            <div class="form-group">
                <label for="sim_sopir">Foto SIM A:</label>
                <input type="file" id="sim_sopir" name="sim_sopir" required>
                <small>Format: jpg, jpeg, png (Max. 5MB)</small>
            </div>

            <div class="form-group">
                <label for="status_sopir">Status:</label>
                <select id="status_sopir" name="status_sopir" required>
                    <option value="tersedia">Tersedia</option>
                    <option value="tidak tersedia">Tidak Tersedia</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel">Batal</button>
                <button type="submit" name="add_sopir" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Sopir -->
<div id="editSopirModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Data Sopir</h2>
            <span class="close">&times;</span>
        </div>
        <form id="editSopirForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit_id_sopir" name="id_sopir">

            <div class="form-group">
                <label for="edit_nama_sopir">Nama Lengkap:</label>
                <input type="text" id="edit_nama_sopir" name="nama_sopir" required>
            </div>

            <div class="form-group">
                <label for="edit_alamat_sopir">Alamat:</label>
                <textarea id="edit_alamat_sopir" name="alamat_sopir" required></textarea>
            </div>

            <div class="form-group">
                <label for="edit_sim_sopir">Foto SIM A:</label>
                <input type="file" id="edit_sim_sopir" name="sim_sopir">
                <img id="current_sim_image" src="" alt="Current SIM" style="max-width: 200px; display: none;">
                <input type="hidden" id="existing_sim" name="existing_sim">
            </div>

            <div class="form-group">
                <label for="edit_status_sopir">Status:</label>
                <select id="edit_status_sopir" name="status_sopir" required>
                    <option value="tersedia">Tersedia</option>
                    <option value="tidak tersedia">Tidak Tersedia</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel">Batal</button>
                <button type="submit" name="update_sopir" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Sopir -->
<div id="deleteSopirModal" class="modal-delete">
    <div class="modal-delete-content">
        <div class="modal-delete-header">
            <h2>Konfirmasi Hapus</h2>
            <span class="close-delete">&times;</span>
        </div>
        <div class="modal-delete-body">
            <p>Apakah Anda yakin ingin menghapus data sopir ini?</p>
        </div>
        <div class="modal-delete-footer">
            <form id="deleteSopirForm" method="POST">
                <input type="hidden" name="id_sopir" id="sopirIdToDelete">
                <button type="button" class="btn-cancel-delete">Batal</button>
                <button type="submit" name="delete_sopir" class="btn-confirm-delete">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add Modal
        const addSopirModal = document.getElementById('addSopirModal');
        const addBtn = document.querySelector('.btn-tambah');
        const closeAddBtn = addSopirModal.querySelector('.close');
        const cancelAddBtn = addSopirModal.querySelector('.btn-cancel');
        const addForm = document.getElementById('addSopirForm');

        // Edit Modal
        const editSopirModal = document.getElementById('editSopirModal');
        const editBtns = document.querySelectorAll('.btn-edit');
        const closeEditBtn = editSopirModal.querySelector('.close');
        const cancelEditBtn = editSopirModal.querySelector('.btn-cancel');

        // Delete Modal
        const deleteSopirModal = document.getElementById('deleteSopirModal');
        const deleteBtns = document.querySelectorAll('.btn-delete');
        const closeDeleteBtn = document.querySelector('#deleteSopirModal .close-delete');
        const cancelDeleteBtn = document.querySelector('#deleteSopirModal .btn-cancel-delete');

        // Add Modal Functions
        function openAddModal() {
            addSopirModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeAddModal() {
            addSopirModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            addForm.reset();
        }

        // Edit Modal Functions
        function openEditModal(driverData) {
            document.getElementById('edit_id_sopir').value = driverData.id_sopir;
            document.getElementById('edit_nama_sopir').value = driverData.nama_sopir;
            document.getElementById('edit_alamat_sopir').value = driverData.alamat_sopir;
            document.getElementById('edit_status_sopir').value = driverData.status_sopir;
            document.getElementById('existing_sim').value = driverData.sim_sopir;

            const currentSimImage = document.getElementById('current_sim_image');
            if (driverData.sim_sopir) {
                currentSimImage.src = 'img/' + driverData.sim_sopir;
                currentSimImage.style.display = 'block';
            } else {
                currentSimImage.style.display = 'none';
            }

            editSopirModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            editSopirModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Delete Modal Functions
        function openDeleteModal(driverId) {
            document.getElementById('sopirIdToDelete').value = driverId;
            deleteSopirModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            deleteSopirModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Event Listeners
        addBtn.addEventListener('click', openAddModal);
        closeAddBtn.addEventListener('click', closeAddModal);
        cancelAddBtn.addEventListener('click', closeAddModal);

        editBtns.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const driverData = {
                    id_sopir: row.getAttribute('data-id'),
                    nama_sopir: row.cells[1].textContent.trim(),
                    alamat_sopir: row.cells[2].textContent.trim(),
                    sim_sopir: row.cells[3].textContent.trim(),
                    status_sopir: row.cells[4].querySelector('select').value
                };
                openEditModal(driverData);
            });
        });

        closeEditBtn.addEventListener('click', closeEditModal);
        cancelEditBtn.addEventListener('click', closeEditModal);

        deleteBtns.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const driverId = this.closest('tr').getAttribute('data-id');
                openDeleteModal(driverId);
            });
        });

        closeDeleteBtn.addEventListener('click', closeDeleteModal);
        cancelDeleteBtn.addEventListener('click', closeDeleteModal);

        // File validation for SIM
        const simInputs = [document.getElementById('sim_sopir'), document.getElementById('edit_sim_sopir')];
        simInputs.forEach(input => {
            input.addEventListener('change', function() {
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

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === addSopirModal) closeAddModal();
            if (event.target === editSopirModal) closeEditModal();
            if (event.target === deleteSopirModal) closeDeleteModal();
        });

        // Close modals on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                if (addSopirModal.style.display === 'block') closeAddModal();
                if (editSopirModal.style.display === 'block') closeEditModal();
                if (deleteSopirModal.style.display === 'block') closeDeleteModal();
            }
        });
    });
</script>