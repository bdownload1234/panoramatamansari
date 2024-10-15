<?php
require_once __DIR__ . '/vendor/autoload.php'; // Ensure the autoload file is included


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdfs'])) {
    $files = $_FILES['pdfs'];
    $totalFiles = count($files['name']);

    // Check if more than one file is uploaded
    if ($totalFiles > 1) {
        $pdf = new FPDI(); // Create an instance of the FPDI class

        foreach ($files['tmp_name'] as $file) {
            if ($file != "") {
                $pageCount = $pdf->setSourceFile($file); // Get the number of pages in the PDF

                // Loop through all pages and import them
                for ($i = 1; $i <= $pageCount; $i++) {
                    $templateId = $pdf->importPage($i);
                    $pdf->AddPage();
                    $pdf->useTemplate($templateId);
                }
            }
        }

        // Output merged PDF file
        $outputPath = 'merged-' . time() . '.pdf';
        $pdf->Output($outputPath, 'F'); // Save merged PDF to file

        // Prompt download of merged file
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($outputPath) . '"');
        readfile($outputPath);

        // Clean up the file from the server after download
        unlink($outputPath);
    } else {
        // If only one file is uploaded, just download it directly
        $tmpFilePath = $files['tmp_name'][0];
        $fileName = $files['name'][0];

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        readfile($tmpFilePath);
    }
}
