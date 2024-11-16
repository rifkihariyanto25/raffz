// Menu switching functionality
const menuItems = document.querySelectorAll(".menu-item");
const pages = {
  Dashboard: document.getElementById("dashboardPage"),
  Mobil: document.getElementById("mobilPage"),
  Sopir: document.getElementById("sopirPage"),
  Booking: document.getElementById("bookingPage"),
  Pengaturan: document.getElementById("pengaturanPage"),
  Pesan: document.getElementById("pesanPage")  // Added Pesan page
};

menuItems.forEach((item) => {
  item.addEventListener("click", () => {
    // Get the text content (page name) from the span element
    const pageName = item.querySelector("span").textContent.trim();

    // Update active menu item
    menuItems.forEach((i) => i.classList.remove("active"));
    item.classList.add("active");

    // Show/hide pages
    Object.values(pages).forEach((page) => {
      if (page) {  // Check if page exists
        page.style.display = "none";
      }
    });

    if (pages[pageName]) {
      pages[pageName].style.display = "block";
    }
  });
});

// Optional: Show dashboard by default on page load
document.addEventListener("DOMContentLoaded", () => {
  // Hide all pages
  Object.values(pages).forEach((page) => {
    if (page) {
      page.style.display = "none";
    }
  });

  // Show dashboard
  if (pages["Dashboard"]) {
    pages["Dashboard"].style.display = "block";

    // Set dashboard menu item as active
    const dashboardMenuItem = Array.from(menuItems).find(
      item => item.querySelector("span").textContent.trim() === "Dashboard"
    );
    if (dashboardMenuItem) {
      dashboardMenuItem.classList.add("active");
    }
  }
});

// Show add car form when "Tambah" button is clicked
document.querySelector('.btn-tambah').addEventListener('click', function () {
  document.getElementById('tambahMobilPage').style.display = 'block';
  document.getElementById('mobilPage').style.display = 'none';
});



// Handle form submission
document.getElementById('addCarForm').addEventListener('submit', function (e) {
  // Add your form submission logic here

  // Hide form and show car list page
  document.getElementById('tambahMobilPage').style.display = 'none';
  document.getElementById('mobilPage').style.display = 'block';
});

// Update file input label when file is selected
document.getElementById('gambarMobil').addEventListener('change', function (e) {
  const fileName = e.target.files[0]?.name || 'Pilih File';
  e.target.previousElementSibling.textContent = fileName;
});


// JavaScript untuk mengatur modal
const modal = document.getElementById('tambahMobilModal');

function openModal() {
  modal.style.display = 'block';
  // Mencegah scroll pada background
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  modal.style.display = 'none';
  // Mengembalikan scroll pada background
  document.body.style.overflow = 'auto';
}

// Menutup modal ketika mengklik di luar modal
window.onclick = function (event) {
  if (event.target == modal) {
    closeModal();
  }
}

// Handle form submission
document.getElementById('addCarForm').addEventListener('submit', function (e) {
  e.preventDefault();

  // Di sini Anda bisa menambahkan kode untuk mengirim data ke server
  const formData = new FormData(this);

  // Contoh log data form
  for (let pair of formData.entries()) {
    console.log(pair[0] + ': ' + pair[1]);
  }

  // Setelah berhasil submit, tutup modal
  closeModal();

  // Reset form
  this.reset();
});






