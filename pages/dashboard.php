<div class="dashboard">
    <div class="container">
        <div class="hero">
            <h1>TraceIt - Product & Environmental Insight</h1>
            <p>Discover the benefits and environmental impact of everyday products</p>
        </div>

        <div class="search-section">
            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="page" value="search">
                <div class="search-input-group">
                    <input type="text" name="query" placeholder="Search for any product..." class="search-input" required>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <div class="categories">
            <h2>Browse Categories</h2>
            <div class="category-grid">
                <a href="index.php?page=category&cat=fruits" class="category-card">
                    <i class="fas fa-apple-alt"></i>
                    <h3>Fruits</h3>
                    <p>Fresh fruits and their nutritional benefits</p>
                </a>

                <a href="index.php?page=category&cat=vegetables" class="category-card">
                    <i class="fas fa-carrot"></i>
                    <h3>Vegetables</h3>
                    <p>Vegetables and their health impact</p>
                </a>

                <a href="index.php?page=category&cat=body-lotions" class="category-card">
                    <i class="fas fa-pump-soap"></i>
                    <h3>Body Lotions</h3>
                    <p>Skincare products and ingredients</p>
                </a>

                <a href="index.php?page=category&cat=sanitary-products" class="category-card">
                    <i class="fas fa-hand-sparkles"></i>
                    <h3>Sanitary Products</h3>
                    <p>Personal hygiene and safety</p>
                </a>

                <a href="index.php?page=category&cat=detergents" class="category-card">
                    <i class="fas fa-spray-can"></i>
                    <h3>Detergents</h3>
                    <p>Cleaning products and chemicals</p>
                </a>

                <a href="index.php?page=category&cat=processed-foods" class="category-card">
                    <i class="fas fa-cookie-bite"></i>
                    <h3>Processed Foods</h3>
                    <p>Packaged foods and additives</p>
                </a>

                <a href="index.php?page=category&cat=plastics" class="category-card">
                    <i class="fas fa-recycle"></i>
                    <h3>Plastics</h3>
                    <p>Plastic products and recycling</p>
                </a>

                <a href="index.php?page=category&cat=beverages" class="category-card">
                    <i class="fas fa-glass-water"></i>
                    <h3>Beverages</h3>
                    <p>Drinks and their ingredients</p>
                </a>

                <a href="index.php?page=category&cat=soaps-creams" class="category-card">
                    <i class="fas fa-soap"></i>
                    <h3>Soaps & Creams</h3>
                    <p>Personal care products</p>
                </a>

                <a href="index.php?page=category&cat=medicines" class="category-card">
                    <i class="fas fa-pills"></i>
                    <h3>Medicines</h3>
                    <p>Pharmaceutical products</p>
                </a>

                <a href="index.php?page=category&cat=cleaning-products" class="category-card">
                    <i class="fas fa-broom"></i>
                    <h3>Cleaning Products</h3>
                    <p>Household cleaning supplies</p>
                </a>

                <a href="index.php?page=scan" class="category-card scan-card">
                    <i class="fas fa-camera"></i>
                    <h3>Scan a Product</h3>
                    <p>Upload photo or barcode</p>
                </a>
            </div>
        </div>
    </div>
</div>