 <?php
    $kritiksaran_result = $conn->query("SELECT * FROM kritiksaran");

    // hapus pesan
    if (isset($_POST['delete_kritik'])) {
        $id_kritik = $_POST['id_kritik'];

        $stmt = $conn->prepare("DELETE FROM kritiksaran WHERE id_kritik = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $id_kritik);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal menghapus data: " . $stmt->error;
        }
        $stmt->close();
    }

    ?>

 <!-- New Messages Page -->
 <div class="header">
     <h2>Kritik Dan Saran User</h2>
     <select class="admin-dropdown">
         <option>admin01</option>
     </select>
 </div>

 <div class="table-container">
     <div class="table-header">
         <div class="table-title">Data Kritik Dan Saran</div>
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
             <?php
                $no = 1;
                while ($kritik = mysqli_fetch_assoc($kritiksaran_result)) :
                ?>
                 <td><?php echo $no++; ?></td>
                 <td><?php echo htmlspecialchars($kritik['namapengirim']); ?></td>
                 <td><?php echo htmlspecialchars($kritik['email']); ?></td>
                 <td><?php echo htmlspecialchars($kritik['kritiksaran']); ?></td>
                 <td class="action-buttons">
                     <button type="button" class="btn-delete" data-id="<?= $kritik['id_kritik'] ?>">
                         <i class="fas fa-trash"></i>
                     </button>
                 </td>
                 </tr>
             <?php endwhile; ?>
         </tbody>
     </table>
 </div>
 </div>

 <!-- hapus pesan -->
 <div id="deletepesan" class="modal-delete">
     <div class="modal-delete-content">
         <div class="modal-delete-header">
             <h2>Konfirmasi Hapus Pesan</h2>
             <span class="close-delete">&times;</span>
         </div>
         <div class="modal-delete-body">
             <p>Apakah Anda yakin ingin menghapus pesan ini?</p>
         </div>
         <div class="modal-delete-footer">
             <form id="deletePesanForm" method="POST">
                 <input type="hidden" name="id_kritik" id="pesanIdToDelete">
                 <button type="button" class="btn-cancel-delete">Batal</button>
                 <button type="submit" name="delete_kritik" class="btn-confirm-delete">Hapus</button>
             </form>
         </div>
     </div>

 </div>

 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const deletePesanModal = document.getElementById('deletepesan');
         // Ubah selector ini dari '.deletepesan' menjadi '.btn-delete'
         const deletePesanButtons = document.querySelectorAll('.btn-delete');
         const closePesanDeleteBtn = document.querySelector('#deletepesan .close-delete');
         const cancelPesanDeleteBtn = document.querySelector('#deletepesan .btn-cancel-delete');
         const deletePesanIdInput = document.getElementById('pesanIdToDelete');

         // Fungsi untuk membuka modal delete pesan
         function openDeletePesanModal(pesanId) {
             deletePesanIdInput.value = pesanId;
             deletePesanModal.style.display = 'block';
             document.body.style.overflow = 'hidden';
         }

         // Fungsi untuk menutup modal delete pesan
         function closeDeletePesanModal() {
             deletePesanModal.style.display = 'none';
             document.body.style.overflow = 'auto';
         }

         // Event listener untuk tombol delete pesan
         deletePesanButtons.forEach(button => {
             button.addEventListener('click', function() {
                 const pesanId = this.getAttribute('data-id');
                 openDeletePesanModal(pesanId);
             });
         });

         // Event listener untuk tombol close dan cancel
         closePesanDeleteBtn.addEventListener('click', closeDeletePesanModal);
         cancelPesanDeleteBtn.addEventListener('click', closeDeletePesanModal);

         // Menutup modal ketika mengklik di luar modal
         window.addEventListener('click', function(event) {
             if (event.target === deletePesanModal) {
                 closeDeletePesanModal();
             }
         });

         // Menutup modal dengan tombol ESC
         document.addEventListener('keydown', function(event) {
             if (event.key === 'Escape' && deletePesanModal.style.display === 'block') {
                 closeDeletePesanModal();
             }
         });
     });
 </script>