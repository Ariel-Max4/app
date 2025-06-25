<?php
require_once 'vendor/autoload.php'; // If using Composer
// If not using Composer, download TCPDF and include it manually
// require_once 'tcpdf/tcpdf.php';

// For this demo, we'll create a simple PDF generation without external libraries
// In production, use TCPDF or FPDF

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'] ?? 'Unknown Product';
    $productInfo = json_decode($_POST['product_info'] ?? '{}', true);
    
    // Set headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . sanitizeFilename($productName) . '_report.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    
    // Simple PDF generation (basic implementation)
    // In production, use a proper PDF library
    generateSimplePDF($productName, $productInfo);
} else {
    header('Location: ../index.php');
    exit;
}

function sanitizeFilename($filename) {
    return preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);
}

function generateSimplePDF($productName, $productInfo) {
    // This is a very basic PDF generation
    // For production use, implement with TCPDF or FPDF
    
    $content = "%PDF-1.4\n";
    $content .= "1 0 obj\n";
    $content .= "<<\n";
    $content .= "/Type /Catalog\n";
    $content .= "/Pages 2 0 R\n";
    $content .= ">>\n";
    $content .= "endobj\n";
    
    $content .= "2 0 obj\n";
    $content .= "<<\n";
    $content .= "/Type /Pages\n";
    $content .= "/Kids [3 0 R]\n";
    $content .= "/Count 1\n";
    $content .= ">>\n";
    $content .= "endobj\n";
    
    $content .= "3 0 obj\n";
    $content .= "<<\n";
    $content .= "/Type /Page\n";
    $content .= "/Parent 2 0 R\n";
    $content .= "/MediaBox [0 0 612 792]\n";
    $content .= "/Contents 4 0 R\n";
    $content .= "/Resources <<\n";
    $content .= "/Font <<\n";
    $content .= "/F1 5 0 R\n";
    $content .= ">>\n";
    $content .= ">>\n";
    $content .= ">>\n";
    $content .= "endobj\n";
    
    $pageContent = "BT\n";
    $pageContent .= "/F1 24 Tf\n";
    $pageContent .= "50 750 Td\n";
    $pageContent .= "(" . addslashes($productName) . " Report) Tj\n";
    $pageContent .= "0 -50 Td\n";
    $pageContent .= "/F1 12 Tf\n";
    
    if (isset($productInfo['benefits'])) {
        $pageContent .= "(Health Benefits:) Tj\n";
        $pageContent .= "0 -20 Td\n";
        $benefits = wordwrap($productInfo['benefits'], 80, "\n", true);
        $lines = explode("\n", $benefits);
        foreach ($lines as $line) {
            $pageContent .= "(" . addslashes($line) . ") Tj\n";
            $pageContent .= "0 -15 Td\n";
        }
    }
    
    if (isset($productInfo['environmental'])) {
        $pageContent .= "0 -10 Td\n";
        $pageContent .= "(Environmental Impact:) Tj\n";
        $pageContent .= "0 -20 Td\n";
        $environmental = wordwrap($productInfo['environmental'], 80, "\n", true);
        $lines = explode("\n", $environmental);
        foreach ($lines as $line) {
            $pageContent .= "(" . addslashes($line) . ") Tj\n";
            $pageContent .= "0 -15 Td\n";
        }
    }
    
    $pageContent .= "ET\n";
    
    $content .= "4 0 obj\n";
    $content .= "<<\n";
    $content .= "/Length " . strlen($pageContent) . "\n";
    $content .= ">>\n";
    $content .= "stream\n";
    $content .= $pageContent;
    $content .= "endstream\n";
    $content .= "endobj\n";
    
    $content .= "5 0 obj\n";
    $content .= "<<\n";
    $content .= "/Type /Font\n";
    $content .= "/Subtype /Type1\n";
    $content .= "/BaseFont /Helvetica\n";
    $content .= ">>\n";
    $content .= "endobj\n";
    
    $content .= "xref\n";
    $content .= "0 6\n";
    $content .= "0000000000 65535 f \n";
    $content .= "0000000010 65535 n \n";
    $content .= "0000000079 65535 n \n";
    $content .= "0000000173 65535 n \n";
    $content .= "0000000301 65535 n \n";
    $content .= "0000000380 65535 n \n";
    $content .= "trailer\n";
    $content .= "<<\n";
    $content .= "/Size 6\n";
    $content .= "/Root 1 0 R\n";
    $content .= ">>\n";
    $content .= "startxref\n";
    $content .= "492\n";
    $content .= "%%EOF\n";
    
    echo $content;
}
?>