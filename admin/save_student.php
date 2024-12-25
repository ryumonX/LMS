<?php
require '..\vendor\autoload.php'; // Load PhpSpreadsheet via Composer
include('dbcon.php'); // Database connection

use PhpOffice\PhpSpreadsheet\IOFactory;
$response = [
    'success' => false,
    'message' => 'An unknown error occurred.',
    'redirect' => '' // Menambahkan URL untuk redirect jika diperlukan
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['method'] ?? null;

    if ($method === 'manual') {
        // Manual Submission
        $class_id = $_POST['class_id'] ?? null;
        $un = $_POST['un'] ?? null;
        $fn = $_POST['fn'] ?? null;
        $ln = $_POST['ln'] ?? null;

        // Validate required fields
        if ($class_id && $un && $fn && $ln) {
            $query = "INSERT INTO student (username, firstname, lastname, location, class_id, status) 
                      VALUES ('$un', '$fn', '$ln', 'uploads/NO-IMAGE-AVAILABLE.jpg', '$class_id', 'Unregistered')";
            if (mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = 'Student added successfully.';
                $response['redirect'] = 'students.php'; // Redirect ke halaman setelah sukses
            } else {
                $response['message'] = 'Database error: ' . mysqli_error($conn);
            }
        } else {
            $response['message'] = 'All fields are required.';
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
            $errors = [];

            foreach ($data as $index => $row) {
                if ($index == 0) continue; // Skip header row

                // Read data from the row
                $fn = trim($row[0] ?? ''); // Username
                $ln = trim($row[1] ?? ''); // Firstname
                $un = trim($row[2] ?? ''); // Lastname
                $class_id = trim($row[3] ?? ''); // Class ID

                // Validate required fields
                if (empty($un) || empty($fn) || empty($ln) || empty($class_id)) {
                    $errorCount++;
                    $errors[] = "Row $index: Missing required fields.";
                    continue;
                }

                // Insert into the database
                $query = "INSERT INTO student (username, firstname, lastname, location, class_id, status) 
                          VALUES ('$un', '$fn', '$ln', 'uploads/NO-IMAGE-AVAILABLE.jpg', '$class_id', 'Unregistered')";
                if (mysqli_query($conn, $query)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = "Row $index: Database error - " . mysqli_error($conn);
                }
            }

            $response['success'] = true;
            $response['message'] = "Import completed. Success: $successCount, Errors: $errorCount.";
            if ($errorCount > 0) {
                $response['errors'] = $errors; // Include detailed errors in the response
            }
            $response['redirect'] = 'students.php'; // Redirect ke halaman setelah sukses
        } catch (Exception $e) {
            $response['message'] = 'Error reading the file: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Invalid method selected.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);

?>
