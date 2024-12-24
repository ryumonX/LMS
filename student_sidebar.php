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

        <?php include('count.php'); ?>

        <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse" id="menu-list">
            <li class="<?php echo $currentPage === 'dashboard_student.php' ? 'active' : ''; ?>">
                <a href="dashboard_student.php">
                    <i class="icon-chevron-right"></i><i class="icon-group"></i>&nbsp;Kelas Saya
                </a>
            </li>
            <li class="<?php echo $currentPage === 'student_notification.php' ? 'active' : ''; ?>">
                <a href="student_notification.php">
                    <i class="icon-chevron-right"></i><i class="icon-info-sign"></i>&nbsp;Notifikasi
                    <?php if (!empty($not_read)) { ?>
                        <span class="badge badge-important"><?php echo (int)$not_read; ?></span>
                    <?php } ?>
                </a>
            </li>
            <?php
            $message_query = mysqli_query(
                $conn,
                "SELECT * FROM message WHERE reciever_id = '$session_id' AND message_status != 'read'"
            ) or die(mysqli_error($conn));
            $count_message = mysqli_num_rows($message_query);
            ?>
            <li class="<?php echo $currentPage === 'student_message.php' ? 'active' : ''; ?>">
                <a href="student_message.php">
                    <i class="icon-chevron-right"></i><i class="icon-envelope-alt"></i>&nbsp;Pesan
                    <?php if ($count_message > 0) { ?>
                        <span class="badge badge-important"><?php echo (int)$count_message; ?></span>
                    <?php } ?>
                </a>
            </li>
            <li class="<?php echo $currentPage === 'backpack.php' ? 'active' : ''; ?>">
                <a href="backpack.php">
                    <i class="icon-chevron-right"></i><i class="icon-suitcase"></i>&nbsp;Tas Saya
                </a>
            </li>
        </ul>
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
