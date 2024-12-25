<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <script src="admin/vendors/flot/jquery.js"></script>
    <script src="admin/bootstrap/js/bootstrap.js"></script>
    <script src="admin/vendors/jGrowl/jquery.jgrowl.js"></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
<div class="row-fluid">
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Tambah Siswa</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form id="add_student_form" enctype="multipart/form-data">
                    <!-- Method Selection -->
                    <div class="control-group">
                        <label>Select Mode:</label>
                        <div class="controls">
                            <label><input type="radio" name="method" value="manual" required> Manual</label>
                            <label><input type="radio" name="method" value="import" required> Import Excel</label>
                        </div>
                    </div>

                    <!-- Manual Input Fields -->
                    <div id="manual_fields" class="hidden">
                        <div class="control-group">
                            <label>Kelas</label>
                            <div class="controls">
                                <select name="class_id" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php
                                    include('dbcon.php');
                                    $stmt = $conn->prepare("SELECT class_id, class_name FROM class ORDER BY class_name");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['class_id']) . '">' . htmlspecialchars($row['class_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label>Username</label>
                            <div class="controls">
                                <input name="un" type="text" class="form-control" placeholder="ID Number" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label>Firstname</label>
                            <div class="controls">
                                <input name="fn" type="text" class="form-control" placeholder="Firstname" required>
                            </div>
                        </div>
                        <div class="control-group">
                            <label>Lastname</label>
                            <div class="controls">
                                <input name="ln" type="text" class="form-control" placeholder="Lastname" required>
                            </div>
                        </div>
                    </div>

                    <!-- Import Fields -->
                    <div id="import_fields" class="hidden">
                        <div class="control-group">
                            <label>Import Excel</label>
                            <div class="controls">
                                <input type="file" name="excel_file" accept=".xls, .xlsx" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <button class="btn btn-info" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Show/Hide fields based on selected method
        $('input[name="method"]').on('change', function() {
            const method = $(this).val();

            if (method === 'manual') {
                $('#manual_fields').removeClass('hidden');
                $('#import_fields').addClass('hidden');

                $('#manual_fields :input').prop('required', true);
                $('#import_fields :input').prop('required', false);
            } else if (method === 'import') {
                $('#import_fields').removeClass('hidden');
                $('#manual_fields').addClass('hidden');

                $('#import_fields :input').prop('required', true);
                $('#manual_fields :input').prop('required', false);
            }
        });

        // Form submission
        $('#add_student_form').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'save_student.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('body').html(response); // Load the response from PHP, including the redirect script
                },
                error: function() {
                    $.jGrowl('Failed to process the request.', { header: 'Error' });
                }
            });
        });
    });
</script>
</body>
</html>
