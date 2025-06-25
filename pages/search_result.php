<?php
$query = $_GET['query'] ?? '';
$result = null;
$error = null;

if ($query) {
    require_once 'api/chatgpt.php';
    
    try {
        $chatgpt = new ChatGPT();
        $result = $chatgpt->getProductInfo($query);
        
        // Log the search
        if (isset($pdo)) {
            $stmt = $pdo->prepare("INSERT INTO search_logs (query, result, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$query, json_encode($result)]);
        }
    } catch (Exception $e) {
        $error = "Error fetching product information: " . $e->getMessage();
    }
}
?>

<div class="search-results">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Dashboard</a> > Search Results
        </div>

        <?php if ($query): ?>
            <div class="search-header">
                <h1>Results for "<?php echo htmlspecialchars($query); ?>"</h1>
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php elseif ($result): ?>
                <div class="result-content">
                    <div class="product-info">
                        <div class="product-header">
                            <h2><?php echo htmlspecialchars($query); ?></h2>
                            <form action="api/generate_pdf.php" method="POST" class="pdf-form">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($query); ?>">
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
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-query">
                <h1>No search query provided</h1>
                <p>Please enter a product name to search.</p>
                <a href="index.php" class="back-btn">Back to Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>