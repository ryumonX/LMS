<?php include('header.php'); ?>
<?php include('session.php'); ?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('teacher_sidebar.php'); ?>
            <div class="span3" id="adduser">
                <?php include('add_teacher.php'); ?>		   			
            </div>
            <div class="span6" id="">
                <div class="row-fluid">
                    <!-- block -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Teacher List</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <form action="delete_teacher.php" method="post">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                                        <a data-toggle="modal" href="#teacher_delete" id="delete" class="btn btn-danger" name="">
                                            <i class="icon-trash icon-large"></i>
                                        </a>
                                        <?php include('modal_delete.php'); ?>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Pagination variables
                                            $records_per_page = 5;
                                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                            $offset = ($page - 1) * $records_per_page;

                                            // Total records
                                            $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM teacher") or die(mysqli_error($conn));
                                            $total_records = mysqli_fetch_assoc($total_records_query)['total'];
                                            $total_pages = ceil($total_records / $records_per_page);

                                            // Fetch paginated data
                                            $teacher_query = mysqli_query($conn, "SELECT * FROM teacher LIMIT $records_per_page OFFSET $offset") or die(mysqli_error($conn));
                                            while ($row = mysqli_fetch_array($teacher_query)) {
                                                $id = $row['teacher_id'];
                                                $teacher_stat = $row['teacher_stat'];
                                                ?>
                                                <tr>
                                                    <td width="30">
                                                        <input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                    </td>
                                                    <td width="40">
                                                        <img class="img-circle" src="<?php echo $row['location']; ?>" height="50" width="50">
                                                    </td>
                                                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td width="50">
                                                        <a href="edit_teacher.php<?php echo '?id=' . $id; ?>" class="btn btn-success">
                                                            <i class="icon-pencil"></i>
                                                        </a>
                                                    </td>
                                                    <!-- Toggle Status Button -->
                                                    <td width="120">
                                                        <a href="toggle_teacher_status.php<?php echo '?id=' . $id; ?>" 
                                                           class="btn <?php echo ($teacher_stat == 'Activated') ? 'btn-danger' : 'btn-success'; ?>">
                                                            <i class="<?php echo ($teacher_stat == 'Activated') ? 'icon-remove' : 'icon-check'; ?>"></i> 
                                                            <?php echo ($teacher_stat == 'Activated') ? 'Deactivate' : 'Activate'; ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </form>

                                <!-- Pagination Links -->
                                <div class="pagination">
                                    <ul>
                                        <?php if ($page > 1): ?>
                                            <li><a href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li <?php if ($page == $i) echo 'class="active"'; ?>>
                                                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li><a href="?page=<?php echo $page + 1; ?>">Next</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>
</html>
