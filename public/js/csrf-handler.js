/**
 * CSRF Token Handler
 * Menangani refresh CSRF token otomatis dan error 419
 */

class CSRFHandler {
    constructor() {
        this.token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.refreshInterval = 30 * 60 * 1000; // 30 menit
        this.warningTime = 5 * 60 * 1000; // 5 menit sebelum expired
        
        this.init();
    }

    init() {
        // Set up automatic token refresh
        this.setupTokenRefresh();
        
        // Handle AJAX errors
        this.setupAjaxErrorHandler();
        
        // Handle form submissions
        this.setupFormHandler();
        
        // Show session warning
        this.setupSessionWarning();
    }

    setupTokenRefresh() {
        setInterval(() => {
            this.refreshToken();
        }, this.refreshInterval);
    }

    async refreshToken() {
        try {
            const response = await fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateToken(data.token);
                console.log('CSRF token refreshed successfully');
            }
        } catch (error) {
            console.warn('Failed to refresh CSRF token:', error);
        }
    }

    updateToken(newToken) {
        this.token = newToken;
        
        // Update meta tag
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            metaTag.setAttribute('content', newToken);
        }
        
        // Update all forms
        document.querySelectorAll('input[name="_token"]').forEach(input => {
            input.value = newToken;
        });
        
        // Update all AJAX headers
        if (window.axios) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = newToken;
        }
        
        if (window.jQuery) {
            window.jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': newToken
                }
            });
        }
    }

    setupAjaxErrorHandler() {
        // Handle fetch errors
        const originalFetch = window.fetch;
        window.fetch = async (...args) => {
            try {
                const response = await originalFetch(...args);
                
                if (response.status === 419) {
                    this.handleCSRFError();
                    return response;
                }
                
                return response;
            } catch (error) {
                throw error;
            }
        };

        // Handle jQuery AJAX errors
        if (window.jQuery) {
            window.jQuery(document).ajaxError((event, xhr, settings) => {
                if (xhr.status === 419) {
                    this.handleCSRFError();
                }
            });
        }

        // Handle Axios errors
        if (window.axios) {
            window.axios.interceptors.response.use(
                response => response,
                error => {
                    if (error.response && error.response.status === 419) {
                        this.handleCSRFError();
                    }
                    return Promise.reject(error);
                }
            );
        }
    }

    setupFormHandler() {
        document.addEventListener('submit', (event) => {
            const form = event.target;
            const tokenInput = form.querySelector('input[name="_token"]');
            
            if (tokenInput && this.token) {
                tokenInput.value = this.token;
            }
        });
    }

    setupSessionWarning() {
        // Show warning 5 minutes before session expires
        setTimeout(() => {
            this.showSessionWarning();
        }, this.refreshInterval - this.warningTime);
    }

    showSessionWarning() {
        const warning = document.createElement('div');
        warning.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg shadow-lg z-50';
        warning.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span>Sesi Anda akan berakhir dalam 5 menit. Klik untuk memperpanjang.</span>
                <button onclick="this.parentElement.parentElement.remove(); window.csrfHandler.refreshToken();" class="ml-2 text-yellow-800 hover:text-yellow-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(warning);
        
        // Auto remove after 10 seconds
        setTimeout(() => {
            if (warning.parentElement) {
                warning.remove();
            }
        }, 10000);
    }

    handleCSRFError() {
        // Show user-friendly message
        this.showCSRFErrorMessage();
        
        // Try to refresh token
        this.refreshToken();
    }

    showCSRFErrorMessage() {
        const message = document.createElement('div');
        message.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50';
        message.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>Sesi Anda telah berakhir. Halaman akan di-refresh otomatis.</span>
            </div>
        `;
        
        document.body.appendChild(message);
        
        // Auto refresh page after 3 seconds
        setTimeout(() => {
            window.location.reload();
        }, 3000);
    }
}

// Initialize CSRF handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.csrfHandler = new CSRFHandler();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CSRFHandler;
}