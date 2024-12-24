<div class="span3" id="sidebar">
    <img id="avatar" class="img-polaroid" src="admin/<?php echo $row['location']; ?>">
    <?php include('count.php'); ?>
    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
        <li class="">
            <a href="dashboard_student.php">
                <i class="icon-chevron-right"></i><i class="icon-group"></i>&nbsp;My Class
            </a>
        </li>
        <li class="active">
            <a href="student_notification.php">
                <i class="icon-chevron-right"></i><i class="icon-info-sign"></i>&nbsp;Notification
                <?php if (!empty($not_read) && $not_read > 0) { ?>
                    <span class="badge badge-important"><?php echo $not_read; ?></span>
                <?php } ?>
            </a>
        </li>
        <?php
        $message_query = mysqli_query($conn, "SELECT * FROM message WHERE reciever_id = '$session_id' AND message_status != 'read'") or die(mysqli_error($conn));
        $count_message = mysqli_num_rows($message_query);
        ?>
        <li class="">
            <a href="student_message.php">
                <i class="icon-chevron-right"></i><i class="icon-envelope-alt"></i>&nbsp;Message
                <?php if (!empty($count_message) && $count_message > 0) { ?>
                    <span class="badge badge-important"><?php echo $count_message; ?></span>
                <?php } ?>
            </a>
        </li>
        <li class="">
            <a href="backpack.php">
                <i class="icon-chevron-right"></i><i class="icon-suitcase"></i>&nbsp;Backpack
            </a>
        </li>
    </ul>
    <?php /* include('search_other_class.php'); */ ?>
</div>
