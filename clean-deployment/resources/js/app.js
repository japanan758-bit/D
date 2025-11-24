import './bootstrap';

/**
 * Clinic Management System JavaScript
 * Supporting RTL, animations, and interactive features
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initLoadingOverlay();
    initSmoothScrolling();
    initAnimations();
    initFormValidation();
    initMobileMenu();
    initScrollToTop();
    
    console.log('Clinic Management System loaded successfully');
});

/**
 * Loading overlay functionality
 */
function initLoadingOverlay() {
    const loadingOverlay = document.getElementById('loading-overlay');
    
    // Hide loading overlay after page load
    setTimeout(() => {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }, 500);
    
    // Show loading overlay for form submissions
    document.addEventListener('submit', function(e) {
        const submitButtons = document.querySelectorAll('button[type="submit"]');
        const isFormSubmit = e.target.tagName === 'FORM' || e.target.closest('form');
        
        if (isFormSubmit && !e.target.classList.contains('no-loading')) {
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }
        }
    });
}

/**
 * Smooth scrolling for anchor links
 */
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Close mobile menu if open
                const mobileMenu = document.querySelector('[x-data]');
                if (mobileMenu && window.Alpine) {
                    // Alpine.js will handle menu close automatically
                }
            }
        });
    });
}

/**
 * Initialize scroll animations
 */
function initAnimations() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements with animation class
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
    
    // Add fade-in class to elements
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach(el => {
        observer.observe(el);
    });
}

/**
 * Enhanced form validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Real-time validation feedback
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            // Clear validation errors on input
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                return false;
            }
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    let isValid = true;
    let message = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        message = 'هذا الحقل مطلوب';
    }
    
    // Email validation
    else if (type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            message = 'البريد الإلكتروني غير صحيح';
        }
    }
    
    // Phone validation (Egyptian numbers)
    else if (type === 'tel' && value) {
        const phoneRegex = /^01[0-9]{9}$/;
        if (!phoneRegex.test(value.replace(/\s+/g, ''))) {
            isValid = false;
            message = 'رقم الهاتف غير صحيح (مثال: 01012345678)';
        }
    }
    
    // Update field appearance
    updateFieldValidation(field, isValid, message);
    
    return isValid;
}

function updateFieldValidation(field, isValid, message) {
    // Remove existing validation classes
    field.classList.remove('border-green-500', 'border-red-500');
    
    // Add appropriate class
    if (isValid) {
        field.classList.add('border-green-500');
    } else {
        field.classList.add('border-red-500');
    }
    
    // Update or create error message
    let errorElement = field.parentNode.querySelector('.field-error');
    if (!isValid && message) {
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error text-red-500 text-sm mt-1';
            field.parentNode.appendChild(errorElement);
        }
        errorElement.textContent = message;
    } else if (errorElement) {
        errorElement.remove();
    }
}

function clearFieldError(field) {
    field.classList.remove('border-red-500');
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

function validateForm(form) {
    const fields = form.querySelectorAll('input, textarea, select');
    let isFormValid = true;
    
    fields.forEach(field => {
        if (!validateField(field)) {
            isFormValid = false;
        }
    });
    
    return isFormValid;
}

/**
 * Mobile menu functionality
 */
function initMobileMenu() {
    const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isOpen = mobileMenu.classList.contains('hidden');
            
            if (isOpen) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('block');
            } else {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });
    }
}

/**
 * Scroll to top functionality
 */
function initScrollToTop() {
    // Create scroll to top button
    const scrollToTopButton = document.createElement('button');
    scrollToTopButton.innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    `;
    scrollToTopButton.className = `
        fixed bottom-6 left-6 z-50 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg
        transition-all duration-300 transform hover:scale-110 hidden
    `;
    scrollToTopButton.setAttribute('aria-label', 'العودة للأعلى');
    document.body.appendChild(scrollToTopButton);
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopButton.classList.remove('hidden');
        } else {
            scrollToTopButton.classList.add('hidden');
        }
    });
    
    // Scroll to top functionality
    scrollToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * Utility functions
 */

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Format phone number
function formatPhoneNumber(input) {
    let value = input.replace(/\D/g, '');
    if (value.length === 11 && value.startsWith('01')) {
        value = '010' + value.substring(3);
    }
    return value;
}

// Copy text to clipboard
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('تم نسخ النص بنجاح', 'success');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showNotification('تم نسخ النص بنجاح', 'success');
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `
        fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm
        ${type === 'success' ? 'bg-green-500 text-white' : 
          type === 'error' ? 'bg-red-500 text-white' : 
          'bg-blue-500 text-white'}
        transform translate-x-full transition-transform duration-300
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Export functions for global use
window.ClinicSystem = {
    debounce,
    formatPhoneNumber,
    copyToClipboard,
    showNotification
};
