<div class="span3" id="sidebar">
    <!-- Wadah gambar -->
    <div id="img-container">
        <img id="avatar" class="img-polaroid" src="admin/<?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?>">
    </div>

    <?php
    // Mendapatkan nama file halaman saat ini
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse" id="menu-list">
        <li class="<?php echo $currentPage === 'dasboard_teacher.php' ? 'active' : ''; ?>">
            <a href="dasboard_teacher.php">
                <i class="icon-chevron-right"></i><i class="icon-chevron-left"></i>&nbsp;Kembali
            </a>
        </li>
        <li class="<?php echo $currentPage === 'my_students.php' ? 'active' : ''; ?>">
            <a href="my_students.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-group"></i>&nbsp;Siswa Saya
            </a>
        </li>
        <li class="<?php echo $currentPage === 'subject_overview.php' ? 'active' : ''; ?>">
            <a href="subject_overview.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-file"></i>&nbsp;Ringkasan Mata Pelajaran
            </a>
        </li>
        <li class="<?php echo $currentPage === 'downloadable.php' ? 'active' : ''; ?>">
            <a href="downloadable.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-download"></i>&nbsp;Materi Unduhan
            </a>
        </li>
        <li class="<?php echo $currentPage === 'assignment.php' ? 'active' : ''; ?>">
            <a href="assignment.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-book"></i>&nbsp;Tugas
            </a>
        </li>
        <li class="<?php echo $currentPage === 'announcements.php' ? 'active' : ''; ?>">
            <a href="announcements.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-info-sign"></i>&nbsp;Pengumuman
            </a>
        </li>
        <li class="<?php echo $currentPage === 'class_calendar.php' ? 'active' : ''; ?>">
            <a href="class_calendar.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-calendar"></i>&nbsp;Kalender Kelas
            </a>
        </li>
        <li class="<?php echo $currentPage === 'class_quiz.php' ? 'active' : ''; ?>">
            <a href="class_quiz.php<?php echo '?id=' . htmlspecialchars($get_id, ENT_QUOTES, 'UTF-8'); ?>">
                <i class="icon-chevron-right"></i><i class="icon-list"></i>&nbsp;Kuis
            </a>
        </li>
    </ul>

    <?php include('search_other_class.php'); ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imgContainer = document.getElementById('img-container');
        const avatarImg = document.getElementById('avatar');
        const menuList = document.getElementById('menu-list');

        // Pindahkan gambar avatar ke daftar menu di tampilan mobile
        function moveImageToMenu() {
            if (window.innerWidth <= 768) {
                if (imgContainer && avatarImg && !menuList.contains(avatarImg)) {
                    menuList.insertBefore(avatarImg, menuList.firstChild);
                }
            } else {
                if (imgContainer && avatarImg && !imgContainer.contains(avatarImg)) {
                    imgContainer.appendChild(avatarImg);
                }
            }
        }

        // Pengecekan awal
        moveImageToMenu();

        // Tangani perubahan ukuran layar
        window.addEventListener('resize', moveImageToMenu);
    });
</script>
