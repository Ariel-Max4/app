<?php
$category = $_GET['cat'] ?? '';
$categoryNames = [
    'fruits' => 'Fruits',
    'vegetables' => 'Vegetables',
    'body-lotions' => 'Body Lotions',
    'sanitary-products' => 'Sanitary Products',
    'detergents' => 'Detergents',
    'processed-foods' => 'Processed Foods',
    'plastics' => 'Plastics',
    'beverages' => 'Beverages',
    'soaps-creams' => 'Soaps & Creams',
    'medicines' => 'Medicines',
    'cleaning-products' => 'Cleaning Products'
];

$categoryName = $categoryNames[$category] ?? 'Unknown Category';
$result = null;
$error = null;

if ($category) {
    require_once 'api/chatgpt.php';
    
    try {
        $chatgpt = new ChatGPT();
        $result = $chatgpt->getCategoryInfo($categoryName);
    } catch (Exception $e) {
        $error = "Error fetching category information: " . $e->getMessage();
    }
}
?>

<div class="category-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Dashboard</a> > <?php echo htmlspecialchars($categoryName); ?>
        </div>

        <div class="category-header">
            <h1><?php echo htmlspecialchars($categoryName); ?></h1>
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
            <div class="category-content">
                <div class="category-info">
                    <div class="info-header">
                        <h2>Category Overview</h2>
                        <form action="api/generate_pdf.php" method="POST" class="pdf-form">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($categoryName . ' Category Overview'); ?>">
                            <input type="hidden" name="product_info" value="<?php echo htmlspecialchars(json_encode($result)); ?>">
                            <button type="submit" class="pdf-btn">
                                <i class="fas fa-download"></i>
                                Download PDF
                            </button>
                        </form>
                    </div>

                    <div class="info-sections">
                        <div class="info-section overview">
                            <h3><i class="fas fa-info-circle"></i> Overview</h3>
                            <div class="content">
                                <?php echo nl2br(htmlspecialchars($result['overview'] ?? 'No overview available.')); ?>
                            </div>
                        </div>

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

                        <?php if (isset($result['examples'])): ?>
                        <div class="info-section examples">
                            <h3><i class="fas fa-list"></i> Common Examples</h3>
                            <div class="content">
                                <?php echo nl2br(htmlspecialchars($result['examples'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="search-in-category">
            <h3>Search within <?php echo htmlspecialchars($categoryName); ?></h3>
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="page" value="search">
                <div class="search-input-group">
                    <input type="text" name="query" placeholder="Search for specific <?php echo strtolower($categoryName); ?>..." class="search-input" required>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>