<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <!-- <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <style>
        /* Improved Modal Popup Styling */
        .form-popup {
            display: none;
            position: fixed;
            bottom: 50px;
            right: 15px;
            transform: translate(-50%, -50%);
            width: 250px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            background-color: white;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .form-container {
            padding: 30px;
            text-align: center;
        }

        .user-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #999;
            cursor: pointer;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .user-modal-close:hover {
            color: #333;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            background-color: #f0f0f0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            font-size: 50px;
            color: #555;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-info h2 {
            margin: 0;
            color: #333;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .user-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-container .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .form-container .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>


<header>
    <nav>
        <div class="logo">
            <img src="../Asset/logo.png" alt="Raffz Car Logo">
        </div>
        <ul>
            <li class="<?php echo $current_page == 'homepage.php' ? 'active' : ''; ?>">
                <a href="../Homepage/homepage.php">Home</a>
            </li>
            <li class="<?php echo $current_page == 'daftarmobildb.php' ? 'active' : ''; ?>">
                <a href="../Listmobil/daftarmobildb.php">Daftar Mobil</a>
            </li>
            <li class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">
                <a href="../Aboutpage/about.php">About</a>
            </li>
            <li class="<?php echo $current_page == 'Kontak.php' ? 'active' : ''; ?>">
                <a href="../Kontak/Kontak.php">Contact</a>
            </li>
        </ul>
        <button class="user-icon" onclick="openForm()">
            <i class="fas fa-user"></i>
        </button>

        <!-- The form -->
        <div class="form-popup" id="myForm">
            <div class="form-container">
                <span class="user-modal-close" onclick="closeUserModal()">&times;</span>

                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <div class="user-info">
                    <h2>Rifki</h2>
                    <p>rifki@example.com</p>
                </div>

                <button type="submit" class="btn">Logout</button>
            </div>
        </div>
    </nav>
</header>

<script>
    // Menambahkan kelas 'scrolled' pada header saat halaman di-scroll
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeUserModal() {
        document.getElementById("myForm").style.display = "none";
    }
</script>


</html>