// TraceIt JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // File input handling
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (label && this.files.length > 0) {
                const fileName = this.files[0].name;
                label.innerHTML = `<i class="fas fa-check"></i> ${fileName}`;
                label.style.background = '#dcfce7';
                label.style.borderColor = '#22c55e';
                label.style.color = '#22c55e';
            }
        });
    });

    // Search form validation
    const searchForms = document.querySelectorAll('.search-form');
    searchForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="query"]');
            if (input && input.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a product name to search.');
                input.focus();
            }
        });
    });

    // Manual form validation
    const manualForms = document.querySelectorAll('.manual-form, .confirm-form');
    manualForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="product_name"]');
            if (input && input.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a product name.');
                input.focus();
            }
        });
    });

    // Upload form validation
    const uploadForms = document.querySelectorAll('.upload-form');
    uploadForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const fileInput = this.querySelector('input[type="file"]');
            if (fileInput && fileInput.files.length === 0) {
                e.preventDefault();
                alert('Please select an image file.');
                fileInput.focus();
            }
        });
    });

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading states to buttons
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            if (form && form.checkValidity()) {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                this.disabled = true;
            }
        });
    });

    // Category card hover effects
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Auto-resize textareas if any
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });

    // Add fade-in animation to content
    const contentSections = document.querySelectorAll('.info-section, .category-card, .scan-method');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    contentSections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });

    // PDF download progress
    const pdfForms = document.querySelectorAll('.pdf-form');
    pdfForms.forEach(form => {
        form.addEventListener('submit', function() {
            const button = this.querySelector('.pdf-btn');
            if (button) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
                button.disabled = true;
                
                // Re-enable button after 3 seconds (in case of issues)
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-download"></i> Download PDF';
                    button.disabled = false;
                }, 3000);
            }
        });
    });
});

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Add notification styles
const notificationStyles = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: slideIn 0.3s ease;
    }
    
    .notification-success {
        background: #22c55e;
    }
    
    .notification-error {
        background: #ef4444;
    }
    
    .notification-info {
        background: #3b82f6;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;

// Inject notification styles
const styleSheet = document.createElement('style');
styleSheet.textContent = notificationStyles;
document.head.appendChild(styleSheet);