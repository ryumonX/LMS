<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Students</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <script src="admin\vendors\flot\jquery.js"></script>
    <script src="admin\bootstrap\js\bootstrap.js"></script>
    <script src="admin\vendors\jGrowl\jquery.jgrowl.js"></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
<div class="row-fluid">
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Add Students</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form id="add_student_form" enctype="multipart/form-data">
                    <!-- Method Selection -->
                    <div class="control-group">
                        <label>Select Mode:</label>
                        <div class="controls">
                            <label><input type="radio" name="method" value="manual" required> Manual</label>
                            <label><input type="radio" name="method" value="import" required> Import</label>
                        </div>
                    </div>

                    <!-- Manual Input Fields -->
                    <div id="manual_fields" class="hidden">
                        <div class="control-group">
                            <label>Class</label>
                            <div class="controls">
                                <select name="class_id" required>
                                    <option value="">Select Class</option>
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
                            <label>ID Number</label>
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
        // Fungsi ketika memilih mode (manual/import)
        $('input[name="method"]').on('change', function() {
            const method = $(this).val();

            if (method === 'manual') {
                $('#manual_fields').removeClass('hidden');
                $('#import_fields').addClass('hidden');

                // Mengaktifkan required untuk input manual
                $('#manual_fields :input').prop('required', true);
                $('#import_fields :input').prop('required', false);
            } else if (method === 'import') {
                $('#import_fields').removeClass('hidden');
                $('#manual_fields').addClass('hidden');

                // Mengaktifkan required untuk input import
                $('#import_fields :input').prop('required', true);
                $('#manual_fields :input').prop('required', false);
            }
        });

        // Fungsi untuk submit form
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
                    try {
                        const result = JSON.parse(response);
                        if (result.success) {
                            $.jGrowl(result.message, { header: 'Success' });
                            setTimeout(function() {
                                window.location.href = 'students.php'; // Redirect setelah sukses
                            }, 2000); // Delay 2 detik sebelum redirect
                        } else {
                            $.jGrowl(result.message, { header: 'Error' });
                        }
                    } catch (error) {
                        $.jGrowl('Invalid response from server.', { header: 'Error' });
                    }
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
