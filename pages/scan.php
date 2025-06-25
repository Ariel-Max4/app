<?php
$result = null;
$error = null;
$productName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_name']) && !empty($_POST['product_name'])) {
        // Manual product name entry
        $productName = trim($_POST['product_name']);
        
        require_once 'api/chatgpt.php';
        try {
            $chatgpt = new ChatGPT();
            $result = $chatgpt->analyzeProductImage($productName);
        } catch (Exception $e) {
            $error = "Error analyzing product: " . $e->getMessage();
        }
    } elseif (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        // Handle file upload
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = uniqid() . '_' . basename($_FILES['product_image']['name']);
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadPath)) {
            // For demo purposes, we'll ask user to confirm the product name
            // In a real app, you'd use OCR or image recognition here
            $imageUploaded = true;
            $uploadedImagePath = $uploadPath;
        } else {
            $error = "Failed to upload image.";
        }
    }
}
?>

<div class="scan-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Dashboard</a> > Scan Product
        </div>

        <div class="scan-header">
            <h1>Scan a Product</h1>
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

        <?php if (!isset($result) && !isset($imageUploaded)): ?>
            <div class="scan-options">
                <div class="scan-methods">
                    <div class="scan-method">
                        <h3><i class="fas fa-camera"></i> Upload Product Image</h3>
                        <p>Take a photo or upload an image of the product</p>
                        <form action="" method="POST" enctype="multipart/form-data" class="upload-form">
                            <div class="file-input-wrapper">
                                <input type="file" name="product_image" id="product_image" accept="image/*" required>
                                <label for="product_image" class="file-input-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Choose Image
                                </label>
                            </div>
                            <button type="submit" class="scan-btn">
                                <i class="fas fa-search"></i>
                                Analyze Image
                            </button>
                        </form>
                    </div>

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <div class="scan-method">
                        <h3><i class="fas fa-keyboard"></i> Enter Product Name</h3>
                        <p>Type the product name directly</p>
                        <form action="" method="POST" class="manual-form">
                            <div class="input-group">
                                <input type="text" name="product_name" placeholder="Enter product name..." required>
                                <button type="submit" class="scan-btn">
                                    <i class="fas fa-search"></i>
                                    Analyze Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($imageUploaded) && !isset($result)): ?>
            <div class="image-confirmation">
                <h3>Image Uploaded Successfully</h3>
                <div class="uploaded-image">
                    <img src="<?php echo htmlspecialchars($uploadedImagePath); ?>" alt="Uploaded product" style="max-width: 300px; max-height: 300px;">
                </div>
                <p>Please confirm the product name:</p>
                <form action="" method="POST" class="confirm-form">
                    <div class="input-group">
                        <input type="text" name="product_name" placeholder="Enter the product name..." required>
                        <button type="submit" class="scan-btn">
                            <i class="fas fa-check"></i>
                            Confirm & Analyze
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif ($result): ?>
            <div class="scan-results">
                <div class="product-info">
                    <div class="product-header">
                        <h2><?php echo htmlspecialchars($productName); ?></h2>
                        <form action="api/generate_pdf.php" method="POST" class="pdf-form">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productName); ?>">
                            <input type="hidden" name="product_info" value="<?php echo htmlspecialchars(json_encode($result)); ?>">
                            <button type="submit" class="pdf-btn">
                                <i class="fas fa-download"></i>
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <div class="info-sections">
                        <div class="info-section benefits">
                            <h3><i class="fas fa-heart"></i> Health Benefits</h3>
                            <div class="content">
                                <?php echo nl2br(htmlspecialchars($result['benefits'] ?? 'No benefits information available.')); ?>
                            </div>
                        </div>

                        <div class="info-section environmental">
                            <h3><i class="fas fa-leaf"></i> Environmental Impact</h3>
                            <div class="content">
                                <?php echo nl2br(htmlspecialchars($result['environmental'] ?? 'No environmental information available.')); ?>
                            </div>
                        </div>

                        <?php if (isset($result['additional'])): ?>
                        <div class="info-section additional">
                            <h3><i class="fas fa-info-circle"></i> Additional Information</h3>
                            <div class="content">
                                <?php echo nl2br(htmlspecialchars($result['additional'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="scan-again">
                    <a href="index.php?page=scan" class="scan-again-btn">
                        <i class="fas fa-camera"></i>
                        Scan Another Product
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>