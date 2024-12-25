<?php include('header.php'); ?>
<?php include('session.php'); ?>

<body>
    <?php include('navbar.php') ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar_dashboard.php'); ?>

            <div class="span9" id="content">
                <div id="block_bg" class="block">
                    <div class="navbar navbar-inner block-header">
                        <h4 class="muted pull-left">Dashboard</h4>
                    </div>
                    <div class="block-content collapse in">
                        <div class="span12" style=" padding: 10px; margin: 10px;">

                            <div class="dashboard-stats row" style="display: flex; justify-content: space-between; flex-wrap: wrap;">

                                <?php
                                $query_teacher = mysqli_query($conn, "select * from teacher") or die(mysqli_error($conn));
                                $count_teacher = mysqli_num_rows($query_teacher);
                                ?>
                                <div class="stat-card" style="background-color: #1d4ed8; color: white; flex: 1; margin: 10px; padding: 30px; border-radius: 10px; text-align: center;">
                                    <i class="fas fa-chalkboard-teacher fa-3x"></i>
                                    <h3 class="stat-number"> <?php echo $count_teacher; ?> </h3>
                                    <p class="stat-label" style="font-weight: bold;">Total Teachers</p>
                                </div>

                                <?php
                                $query_student = mysqli_query($conn, "select * from student") or die(mysqli_error($conn));
                                $count_student = mysqli_num_rows($query_student);
                                ?>
                                <div class="stat-card" style="background-color: #f97316; color: white; flex: 1; margin: 10px; padding: 30px; border-radius: 10px; text-align: center;">
                                    <i class="fas fa-user-graduate fa-3x"></i>
                                    <h3 class="stat-number"> <?php echo $count_student; ?> </h3>
                                    <p class="stat-label" style="font-weight: bold;">Total Students</p>
                                </div>

                                <?php
                                $query_class = mysqli_query($conn, "select * from class") or die(mysqli_error($conn));
                                $count_class = mysqli_num_rows($query_class);
                                ?>
                                <div class="stat-card" style="background-color: #2563eb; color: white; flex: 1; margin: 10px; padding: 30px; border-radius: 10px; text-align: center;">
                                    <i class="fas fa-school fa-3x"></i>
                                    <h3 class="stat-number"> <?php echo $count_class; ?> </h3>
                                    <p class="stat-label" style="font-weight: bold;">Total Classes</p>
                                </div>
                            </div>

                            <div class="dashboard-stats row" style="display: flex; justify-content: space-between; flex-wrap: wrap; margin-top: 20px;">

                                <?php
                                $query_file = mysqli_query($conn, "select * from files") or die(mysqli_error($conn));
                                $count_file = mysqli_num_rows($query_file);
                                ?>
                                <div class="stat-card" style="background-color: green; color: white; flex: 1; margin: 10px; padding: 30px; border-radius: 10px; text-align: center;">
                                    <canvas id="fileChart" style="height: 175px; width: 100%;"></canvas>
                                </div>

                                <?php
                                $query_subject = mysqli_query($conn, "select * from subject") or die(mysqli_error($conn));
                                $count_subject = mysqli_num_rows($query_subject);
                                ?>
                                <div class="stat-card" style="background-color: #ef4444; 
                                color: white; flex: 0 1 20%; margin: 10px; padding: 40px 30px 30px 30px; border-radius: 10px; text-align: center; height: 180px;">
                                    <i class="fas fa-book fa-3x" style="margin-top: 20px;"></i>
                                    <h3 class="stat-number"> <?php echo $count_subject; ?> </h3>
                                    <p class="stat-label">Total Subjects</p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('fileChart').getContext('2d');
        var fileChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Downloadable Files', 'Other Files'],
                datasets: [{
                    label: 'Files',
                    data: [<?php echo $count_file; ?>, 100 - <?php echo $count_file; ?>],
                    backgroundColor: [
                        '#facc15',
                        '#e5e7eb'
                    ],
                    borderColor: [
                        '#facc15',
                        '#e5e7eb'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'white' // Set legend text color to white
                        }
                    },
                    title: {
                        display: true,
                        text: 'Downloadable Files Overview',
                        color: 'white' // Set title text color to white
                    }
                },
                maintainAspectRatio: false, // Disable aspect ratio to allow custom height
                height: 300 // Set chart height to 300px
            }
        });
    </script>

</body>

</html>