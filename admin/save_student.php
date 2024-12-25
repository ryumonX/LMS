<?php
require '..\vendor\autoload.php'; // Load PhpSpreadsheet via Composer
include('dbcon.php'); // Database connection

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['method'] ?? null;

    if ($method === 'manual') {
        // Manual Submission
        $class_id = $_POST['class_id'] ?? null;
        $un = $_POST['un'] ?? null;
        $fn = $_POST['fn'] ?? null;
        $ln = $_POST['ln'] ?? null;

        // Generate random password
        $randomPassword = random_int(100000, 999999); // 6 digit nomor acak

        // Validate required fields
        if ($class_id && $un && $fn && $ln) {
            $query = "INSERT INTO student (username, firstname, lastname, location, class_id, status, password) 
                      VALUES ('$un', '$fn', '$ln', 'uploads/NO-IMAGE-AVAILABLE.jpg', '$class_id', 'Unregistered', '$randomPassword')";
            if (mysqli_query($conn, $query)) {
                echo "<script>
                        alert('Student added successfully. Password: $randomPassword');
                        window.location = 'students.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Database error: " . mysqli_error($conn) . "');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('All fields are required.');
                  </script>";
        }
    } elseif ($method === 'import' && isset($_FILES['excel_file'])) {
        // Import from Excel
        $file = $_FILES['excel_file']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            $successCount = 0;
            $errorCount = 0;

            foreach ($data as $index => $row) {
                if ($index == 0) continue; // Skip header row

                // Read data from the row
                $fn = trim($row[0] ?? ''); // Firstname
                $ln = trim($row[1] ?? ''); // Lastname
                $un = trim($row[2] ?? ''); // ID Number
                $class_id = trim($row[3] ?? ''); // Class ID

                // Generate random password
                $randomPassword = random_int(100000, 999999); // 6 digit nomor acak

                // Validate required fields
                if (empty($un) || empty($fn) || empty($ln) || empty($class_id)) {
                    $errorCount++;
                    continue;
                }

                // Insert into the database
                $query = "INSERT INTO student (username, firstname, lastname, location, class_id, status, password) 
                          VALUES ('$un', '$fn', '$ln', 'uploads/NO-IMAGE-AVAILABLE.jpg', '$class_id', 'Unregistered', '$randomPassword')";
                if (mysqli_query($conn, $query)) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }

            echo "<script>
                    alert('Import completed. Success: $successCount, Errors: $errorCount.');
                    window.location = 'students.php';
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    alert('Error reading file: " . $e->getMessage() . "');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid method selected.');
              </script>";
    }
}
?>
