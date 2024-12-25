<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Responsif</title>
    <style>
        /* General styles for the sidebar */
        .span3 {
            width: 300px;
            padding: 15px;
            background-color: #f8f9fa;
            transition: all 0.3s ease-in-out;
        }

        #avatar {
            width: 150px;
            height: 150px;
            transition: transform 0.3s ease-in-out;
        }

        .nav-list {
            list-style-type: none;
            padding: 0;
        }

        .nav-list li {
            margin-bottom: 10px;
            transition: all 0.3s ease-in-out;
        }

        .nav-list li.active a {
            font-weight: bold;
        }

        .nav-collapse, .collapse {
            filter: none !important;
            backdrop-filter: none !important;
            opacity: 1 !important;
            transform: none !important;
        }

        @media (max-width: 768px) {
            #img-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $get_id = isset($_GET['id']) ? $_GET['id'] : '';
    ?>
    <div class="span3" id="sidebar">
        <!-- Image container -->
        <div id="img-container">
            <img id="avatar" src="admin/<?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?>" class="img-polaroid">
        </div>
        
        <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse" id="menu-list">
            <li class="<?php echo $currentPage === 'dashboard_student.php' ? 'active' : ''; ?>">
                <a href="dashboard_student.php">
                    <i class="icon-chevron-right"></i><i class="icon-chevron-left"></i>&nbsp;Kembali
                </a>
            </li>
            <li class="<?php echo $currentPage === 'my_classmates.php' ? 'active' : ''; ?>">
                <a href="my_classmates.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-group"></i>&nbsp;Teman Sekelas Saya
                </a>
            </li>
            <li class="<?php echo $currentPage === 'progress.php' ? 'active' : ''; ?>">
                <a href="progress.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-bar-chart"></i>&nbsp;Progres Saya
                </a>
            </li>
            <li class="<?php echo $currentPage === 'subject_overview_student.php' ? 'active' : ''; ?>">
                <a href="subject_overview_student.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-file"></i>&nbsp;Ikhtisar Mata Pelajaran
                </a>
            </li>
            <li class="<?php echo $currentPage === 'downloadable_student.php' ? 'active' : ''; ?>">
                <a href="downloadable_student.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-download"></i>&nbsp;Materi yang Dapat Diunduh
                </a>
            </li>
            <li class="<?php echo $currentPage === 'assignment_student.php' ? 'active' : ''; ?>">
                <a href="assignment_student.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-book"></i>&nbsp;Tugas
                </a>
            </li>
            <li class="<?php echo $currentPage === 'announcements_student.php' ? 'active' : ''; ?>">
                <a href="announcements_student.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-info-sign"></i>&nbsp;Pengumuman
                </a>
            </li>
            <li class="<?php echo $currentPage === 'class_calendar_student.php' ? 'active' : ''; ?>">
                <a href="class_calendar_student.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-calendar"></i>&nbsp;Kalender Kelas
                </a>
            </li>
            <li class="<?php echo $currentPage === 'student_quiz_list.php' ? 'active' : ''; ?>">
                <a href="student_quiz_list.php<?php echo '?id=' . urlencode($get_id); ?>">
                    <i class="icon-chevron-right"></i><i class="icon-reorder"></i>&nbsp;Kuis
                </a>
            </li>
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imgContainer = document.getElementById('img-container');
            const avatarImg = document.getElementById('avatar');
            const menuList = document.getElementById('menu-list');

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

            moveImageToMenu();
            window.addEventListener('resize', moveImageToMenu);
        });
    </script>
</body>
</html>
