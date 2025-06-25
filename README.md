# TraceIt - Product & Environmental Insight

A PHP web application that helps users understand the benefits and environmental effects of products using AI-powered insights from OpenAI's ChatGPT.

## Features

- **Product Search**: Search for any product by name and get detailed information
- **Category Browsing**: Browse products by categories like Fruits, Vegetables, Body Lotions, etc.
- **Image Upload**: Upload product images for analysis
- **PDF Reports**: Download detailed reports as PDF files
- **AI-Powered**: Uses OpenAI ChatGPT for real-time product information
- **Responsive Design**: Works on desktop and mobile devices

## Setup Instructions

### 1. Prerequisites
- PHP 7.4 or higher
- MySQL database (optional)
- Web server (Apache/Nginx)
- OpenAI API key

### 2. Installation

1. Clone or download the project files
2. Configure your web server to serve the project directory
3. Set up the OpenAI API key:
   - Open `config/openai.php`
   - Replace `'your-openai-api-key-here'` with your actual OpenAI API key

### 3. Database Setup (Optional)

If you want to enable search logging:

1. Create a MySQL database named `traceit`
2. Import the `database.sql` file
3. Update database credentials in `config/database.php`

### 4. File Permissions

Make sure the `uploads/` directory is writable:
```bash
chmod 755 uploads/
```

### 5. OpenAI API Key

1. Go to [OpenAI API Keys](https://platform.openai.com/api-keys)
2. Create a new API key
3. Update `config/openai.php` with your key

## Usage

### Dashboard
- Visit the main page to see category cards
- Click on any category to get AI-generated information about that product category
- Use the search bar to find specific products

### Search
- Enter any product name in the search bar
- Get detailed information about health benefits and environmental impact
- Download results as PDF

### Scan Product
- Upload an image of a product
- Confirm the product name
- Get AI analysis of the product

### PDF Download
- Click the "Download PDF" button on any result page
- Get a formatted PDF report with all the information

## File Structure

```
traceit/
├── index.php              # Main entry point
├── pages/                 # Page templates
│   ├── dashboard.php      # Homepage with categories
│   ├── search_result.php  # Search results page
│   ├── category.php       # Category information page
│   └── scan.php          # Product scanning page
├── api/                   # API handlers
│   ├── chatgpt.php       # OpenAI API integration
│   └── generate_pdf.php  # PDF generation
├── config/                # Configuration files
│   ├── database.php      # Database connection
│   └── openai.php        # OpenAI API configuration
├── assets/                # Static assets
│   ├── css/style.css     # Main stylesheet
│   └── js/main.js        # JavaScript functionality
├── uploads/               # Uploaded files directory
└── database.sql          # Database schema
```

## Customization

### Adding New Categories
1. Edit `pages/dashboard.php`
2. Add new category cards to the grid
3. Update the category mapping in `pages/category.php`

### Styling
- Modify `assets/css/style.css` for visual changes
- The design uses a modern gradient-based theme
- Fully responsive design included

### API Prompts
- Customize ChatGPT prompts in `api/chatgpt.php`
- Modify the `getProductInfo()` and `getCategoryInfo()` methods

## Security Notes

- Never commit your OpenAI API key to version control
- Validate all user inputs
- Implement proper file upload restrictions
- Use HTTPS in production
- Consider rate limiting for API calls

## Troubleshooting

### Common Issues

1. **API Key Error**: Make sure your OpenAI API key is correctly set in `config/openai.php`
2. **Upload Issues**: Check that the `uploads/` directory exists and is writable
3. **Database Connection**: Verify database credentials in `config/database.php`
4. **PDF Generation**: The current PDF implementation is basic - consider using TCPDF or FPDF for production

### Error Messages
- Check browser console for JavaScript errors
- Enable PHP error reporting for debugging
- Verify file permissions

## Production Deployment

1. Use environment variables for sensitive configuration
2. Implement proper error handling and logging
3. Add input validation and sanitization
4. Use a proper PDF library (TCPDF/FPDF)
5. Implement caching for API responses
6. Add rate limiting
7. Use HTTPS
8. Regular security updates

## License

This project is open source. Feel free to modify and use as needed.

## Support

For issues or questions, please check the code comments and this README file.