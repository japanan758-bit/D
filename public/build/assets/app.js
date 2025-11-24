// Enhanced JavaScript for Clinic Management System

// Global configuration
window.ClinicSystem = window.ClinicSystem || {};

// Utility functions
window.ClinicSystem.utils = {
    // Show alert message
    showAlert: function(message, type = 'info', duration = 5000) {
        const alert = document.createElement('div');
        alert.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'error' ? 'bg-red-500' : 
            type === 'success' ? 'bg-green-500' : 
            type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
        } text-white`;
        alert.textContent = message;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, duration);
    },
    
    // Confirm action
    confirmAction: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    },
    
    // Format currency
    formatCurrency: function(amount) {
        return new Intl.NumberFormat('ar-SA', {
            style: 'currency',
            currency: 'SAR'
        }).format(amount);
    },
    
    // Format date
    formatDate: function(date, options = {}) {
        const defaultOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return new Date(date).toLocaleDateString('ar-SA', { ...defaultOptions, ...options });
    },
    
    // Generate random ID
    generateId: function() {
        return Math.random().toString(36).substr(2, 9);
    },
    
    // Debounce function
    debounce: function(func, wait) {
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
};

// Form utilities
window.ClinicSystem.forms = {
    // Validate form
    validate: function(form) {
        const errors = [];
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                errors.push(`${input.name || input.id} is required`);
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        return errors;
    },
    
    // Submit form with validation
    submit: function(form, callback) {
        const errors = this.validate(form);
        
        if (errors.length > 0) {
            window.ClinicSystem.utils.showAlert('Please fix the following errors: ' + errors.join(', '), 'error');
            return false;
        }
        
        // Show loading state
        const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
        const originalText = submitButton ? submitButton.textContent : '';
        
        if (submitButton) {
            submitButton.textContent = 'جاري التحميل...';
            submitButton.disabled = true;
            submitButton.classList.add('opacity-75');
        }
        
        // Simulate form submission or call callback
        if (callback) {
            callback(form)
                .then(() => {
                    if (submitButton) {
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-75');
                    }
                })
                .catch(() => {
                    if (submitButton) {
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-75');
                    }
                });
        }
        
        return true;
    }
};

// Appointment management
window.ClinicSystem.appointments = {
    // Book appointment
    book: function(formData) {
        // Simulate API call
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                if (Math.random() > 0.1) { // 90% success rate
                    resolve({ id: Date.now(), ...formData });
                } else {
                    reject(new Error('Booking failed'));
                }
            }, 1000);
        });
    },
    
    // Cancel appointment
    cancel: function(appointmentId) {
        window.ClinicSystem.utils.confirmAction(
            'هل أنت متأكد من إلغاء الموعد؟',
            () => {
                // Simulate API call
                window.ClinicSystem.utils.showAlert('تم إلغاء الموعد بنجاح', 'success');
            }
        );
    }
};

// Patient management
window.ClinicSystem.patients = {
    // Add patient
    add: function(patientData) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                if (Math.random() > 0.05) { // 95% success rate
                    resolve({ id: Date.now(), ...patientData });
                } else {
                    reject(new Error('Failed to add patient'));
                }
            }, 800);
        });
    },
    
    // Search patients
    search: function(query) {
        // Simulate search
        const results = [];
        // In real implementation, this would be an API call
        console.log('Searching patients for:', query);
        return results;
    }
};

// Doctor management
window.ClinicSystem.doctors = {
    // Get doctor info
    getInfo: function(doctorId) {
        // Simulate API call
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({
                    id: doctorId,
                    name: 'د. عبدالناصر الأخرس',
                    specialty: 'استشاري جراحات الشبكية والمياه البيضاء',
                    experience: '20+ سنة',
                    rating: 4.8
                });
            }, 500);
        });
    },
    
    // Get available slots
    getAvailableSlots: function(date) {
        // Simulate slot generation
        const slots = [];
        for (let hour = 9; hour <= 17; hour++) {
            if (hour !== 12) { // Lunch break
                slots.push(`${hour}:00`, `${hour}:30`);
            }
        }
        return slots;
    }
};

// Data table utilities
window.ClinicSystem.tables = {
    // Sort table
    sort: function(table, column, direction = 'asc') {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aText = a.cells[column].textContent.trim();
            const bText = b.cells[column].textContent.trim();
            
            if (direction === 'asc') {
                return aText.localeCompare(bText);
            } else {
                return bText.localeCompare(aText);
            }
        });
        
        rows.forEach(row => tbody.appendChild(row));
    },
    
    // Filter table
    filter: function(table, searchTerm) {
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const match = text.includes(searchTerm.toLowerCase());
            row.style.display = match ? '' : 'none';
        });
    },
    
    // Export table to CSV
    exportToCSV: function(table, filename = 'export.csv') {
        const rows = table.querySelectorAll('tr');
        const csvContent = Array.from(rows)
            .map(row => {
                const cells = row.querySelectorAll('td, th');
                return Array.from(cells)
                    .map(cell => `"${cell.textContent.trim()}"`)
                    .join(',');
            })
            .join('\n');
        
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();
    }
};

// Mobile utilities
window.ClinicSystem.mobile = {
    // Toggle mobile menu
    toggleMenu: function() {
        const menu = document.getElementById('mobile-menu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    },
    
    // Check if mobile
    isMobile: function() {
        return window.innerWidth < 768;
    }
};

// Analytics utilities
window.ClinicSystem.analytics = {
    // Track event
    track: function(eventName, data = {}) {
        console.log('Analytics event:', eventName, data);
        // In real implementation, send to analytics service
    },
    
    // Track page view
    trackPageView: function(pageName) {
        this.track('page_view', { page: pageName });
    }
};

// Global initialization
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('[onclick="toggleMobileMenu()"]');
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', window.ClinicSystem.mobile.toggleMenu);
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
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
    
    // Form handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            window.ClinicSystem.forms.submit(this);
        });
    });
    
    // Auto-save forms
    const autoSaveForms = document.querySelectorAll('form[data-autosave]');
    autoSaveForms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('change', window.ClinicSystem.utils.debounce(() => {
                // Auto-save logic here
                console.log('Auto-saving form data...');
            }, 2000));
        });
    });
    
    // Add animations to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate-fade-in');
        }, index * 100);
    });
    
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute bg-gray-800 text-white text-xs rounded py-1 px-2 z-50';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            tooltip.style.left = rect.left + 'px';
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.absolute.bg-gray-800');
            if (tooltip) tooltip.remove();
        });
    });
    
    // Track page view
    window.ClinicSystem.analytics.trackPageView(window.location.pathname);
    
    console.log('Clinic Management System loaded successfully');
});

// Utility functions
window.ClinicSystem = {
    // Show alert message
    showAlert: function(message, type = 'info') {
        const alert = document.createElement('div');
        alert.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500'} text-white`;
        alert.textContent = message;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    },
    
    // Confirm action
    confirmAction: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    },
    
    // Format currency
    formatCurrency: function(amount) {
        return new Intl.NumberFormat('ar-SA', {
            style: 'currency',
            currency: 'SAR'
        }).format(amount);
    }
};