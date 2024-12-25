<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Responsif</title>
    <style>
        /* General styles for the sidebar */
        .span3 {
            width: 300px;
            padding: 15px;
            background-color: #f8f9fa; /* Background for better visibility */
            transition: all 0.3s ease-in-out; /* Smooth transition for the sidebar */
        }

        #avatar {
            width: 150px;
            height: 150px;
            transition: transform 0.3s ease-in-out; /* Smooth transition for the avatar */
        }

        .nav-list {
            list-style-type: none;
            padding: 0;
        }

        .nav-list li {
            margin-bottom: 10px;
            transition: all 0.3s ease-in-out; /* Smooth hover transition for items */
        }

        .nav-list li.active a {
            font-weight: bold;
            /* color: #007bff; Highlight active link */
        }

        /* Adjustments for the transition while ensuring no blur effect */
        .nav-collapse, .collapse {
            filter: none !important; /* Remove blur effects */
            backdrop-filter: none !important;
            opacity: 1 !important;
            transform: none !important;
        }

        /* Hide image container on mobile view */
        @media (max-width: 768px) {
            #img-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name
    ?>
    <div class="span3" id="sidebar">
        <!-- Image container -->
        <div id="img-container">
            <img id="avatar" class="img-polaroid" src="admin/<?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        
        <?php include('teacher_count.php'); ?>

        <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse" id="menu-list">
            <li class="<?php echo $currentPage === 'dasboard_teacher.php' ? 'active' : ''; ?>">
                <a href="dasboard_teacher.php">
                    <i class="icon-chevron-right"></i><i class="icon-group"></i>&nbsp;Kelas Saya
                </a>
            </li>
            <li class="<?php echo $currentPage === 'notification_teacher.php' ? 'active' : ''; ?>">
                <a href="notification_teacher.php">
                    <i class="icon-chevron-right"></i><i class="icon-info-sign"></i>&nbsp;Notifikasi
                    <?php if (!empty($not_read)) { ?>
                        <span class="badge badge-important"><?php echo (int)$not_read; ?></span>
                    <?php } ?>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'teacher_message.php' ? 'active' : ''; ?>">
                <a href="teacher_message.php">
                    <i class="icon-chevron-right"></i><i class="icon-envelope-alt"></i>&nbsp;Pesan
                </a>
            </li>
            <li class="<?php echo $currentPage === 'teacher_backack.php' ? 'active' : ''; ?>">
                <a href="teacher_backack.php">
                    <i class="icon-chevron-right"></i><i class="icon-suitcase"></i>&nbsp;Tas Guru
                </a>
            </li>
            <li class="<?php echo $currentPage === 'add_downloadable.php' ? 'active' : ''; ?>">
                <a href="add_downloadable.php">
                    <i class="icon-chevron-right"></i><i class="icon-plus-sign"></i>&nbsp;Tambah File Unduhan
                </a>
            </li>
            <li class="<?php echo $currentPage === 'add_announcement.php' ? 'active' : ''; ?>">
                <a href="add_announcement.php">
                    <i class="icon-chevron-right"></i><i class="icon-plus-sign"></i>&nbsp;Tambah Pengumuman
                </a>
            </li>
            <li class="<?php echo $currentPage === 'add_assignment.php' ? 'active' : ''; ?>">
                <a href="add_assignment.php">
                    <i class="icon-chevron-right"></i><i class="icon-plus-sign"></i>&nbsp;Tambah Tugas
                </a>
            </li>
            <li class="<?php echo $currentPage === 'teacher_quiz.php' ? 'active' : ''; ?>">
                <a href="teacher_quiz.php">
                    <i class="icon-chevron-right"></i><i class="icon-list"></i>&nbsp;Kuis
                </a>
            </li>
            <li class="<?php echo $currentPage === 'teacher_share.php' ? 'active' : ''; ?>">
                <a href="teacher_share.php">
                    <i class="icon-chevron-right"></i><i class="icon-file"></i>&nbsp;File Dibagikan
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

            // Move the avatar image to menu list in mobile view
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

            // Initial check
            moveImageToMenu();

            // Handle resize events
            window.addEventListener('resize', moveImageToMenu);
        });
    </script>
</body>
</html>
