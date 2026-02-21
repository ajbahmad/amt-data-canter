@props([
    'id' => 'formModal',
    'title' => 'Form',
    'formId' => 'modalForm',
    'method' => 'POST',
    'action' => '',
    'size' => 'lg',
    'submitText' => 'Submit',
    'cancelText' => 'Cancel',
    'submitColor' => 'blue', // blue, green, red, yellow, purple, gray
    'showCancel' => true,
    'enctype' => 'application/x-www-form-urlencoded', // multipart/form-data for file uploads
    'loadingText' => 'Processing...',
    'resetOnClose' => true,
    'validateOnSubmit' => true,
    'scrollToError' => true,
    'autoClose' => true, // Auto close on successful submit
    'maxHeight' => '70vh',
])

@php
    $colorClasses = [
        'blue' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        'green' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
        'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'yellow' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500',
        'purple' => 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500',
        'gray' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500',
    ];

    $submitColorClass = $colorClasses[$submitColor] ?? $colorClasses['blue'];
@endphp

<x-modal :id="$id" :title="$title" :size="$size" :show-footer="true" :max-height="$maxHeight">

    {{-- Form Content --}}
    <form id="{{ $formId }}"
          method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
          @if($action) action="{{ $action }}" @endif
          @if($enctype === 'multipart/form-data') enctype="multipart/form-data" @endif
          class="form-modal"
          data-reset-on-close="{{ $resetOnClose ? 'true' : 'false' }}"
          data-validate-on-submit="{{ $validateOnSubmit ? 'true' : 'false' }}"
          data-scroll-to-error="{{ $scrollToError ? 'true' : 'false' }}"
          data-auto-close="{{ $autoClose ? 'true' : 'false' }}">

        @if(strtoupper($method) !== 'GET')
            @csrf
        @endif

        @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <div class="p-4">
            {{ $slot }}
        </div>
    </form>

    {{-- Footer --}}
    <x-slot name="footer">
        @if($showCancel)
            <button type="button"
                class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-gray-600 dark:focus:ring-offset-gray-800 transition-colors duration-150"
                data-hs-overlay="#{{ $id }}"
                onclick="handleFormModalCancel('{{ $formId }}', '{{ $id }}')">
                {{ $cancelText }}
            </button>
        @endif

        <button type="submit"
            form="{{ $formId }}"
            id="btn{{$formId}}"
            class="flex items-center gap-3 py-2 px-4 text-sm font-medium rounded-lg border border-transparent {{ $submitColorClass }} text-white disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-150 submit-btn">
            <span class="inline-block size-4 animate-spin border-[3px] border-current border-t-transparent text-white rounded-full hidden loading-spinner"
                  role="status"
                  aria-label="loading">
            </span>
            <span class="btn-text">{{ $submitText }}</span>
        </button>
    </x-slot>
</x-modal>

@once
    @push('scripts')
    <script>
        // Form Modal Utilities
        window.formModalUtils = {

            // Open form modal and optionally populate with data
            open: function(modalId, data = null, title = null) {
                const modal = document.getElementById(modalId);
                const form = modal.querySelector('.form-modal');

                if (title) {
                    const titleElement = modal.querySelector('h3');
                    if (titleElement) titleElement.textContent = title;
                }

                if (data) {
                    this.populateForm(form, data);
                }

                this.clearValidation(form);
                modalUtils.open(modalId);
            },

            // Close form modal
            close: function(modalId, resetForm = null) {
                const modal = document.getElementById(modalId);
                const form = modal.querySelector('.form-modal');

                if (resetForm === null) {
                    resetForm = form.dataset.resetOnClose === 'true';
                }

                if (resetForm) {
                    form.reset();
                    this.clearValidation(form);
                }

                modalUtils.close(modalId);
            },

            // Populate form with data
            populateForm: function(form, data) {
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = !!data[key];
                        } else if (input.type === 'radio') {
                            const radio = form.querySelector(`[name="${key}"][value="${data[key]}"]`);
                            if (radio) radio.checked = true;
                        } else {
                            input.value = data[key] || '';
                        }
                    }
                });
            },

            // Show validation errors
            showValidationErrors: function(form, errors) {
                this.clearValidation(form);

                Object.keys(errors).forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        this.showFieldError(input, errors[field][0]);
                    }
                });

                // Scroll to first error if enabled
                if (form.dataset.scrollToError === 'true') {
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            },

            // Show field error
            showFieldError: function(input, message) {
                input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                input.classList.remove('border-gray-200', 'focus:border-blue-500', 'focus:ring-blue-500');

                let feedback = input.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback text-red-500 text-sm mt-1';
                    input.parentNode.appendChild(feedback);
                }

                feedback.textContent = message;
                feedback.classList.remove('hidden');
            },

            // Clear all validation errors
            clearValidation: function(form) {
                form.querySelectorAll('.border-red-500').forEach(element => {
                    element.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                    element.classList.add('border-gray-200', 'focus:border-blue-500', 'focus:ring-blue-500');
                });

                form.querySelectorAll('.invalid-feedback').forEach(element => {
                    element.textContent = '';
                    element.classList.add('hidden');
                });
            },

            // Set loading state
            setLoading: function(form, loading = true, loadingText = 'Processing...') {
                const submitBtn = form.closest('.hs-overlay').querySelector('.submit-btn');
                const spinner = submitBtn.querySelector('.loading-spinner');
                const btnText = submitBtn.querySelector('.btn-text');

                if (loading) {
                    submitBtn.disabled = true;
                    spinner.classList.remove('hidden');
                    btnText.textContent = loadingText;
                } else {
                    submitBtn.disabled = false;
                    spinner.classList.add('hidden');
                    btnText.textContent = btnText.dataset.originalText || 'Submit';
                }
            },

            // Handle form submission with AJAX
            submitForm: function(form, options = {}) {
                const defaultOptions = {
                    onSuccess: null,
                    onError: null,
                    onValidationError: null,
                    loadingText: 'Processing...',
                    successMessage: 'Operation completed successfully!',
                    showSuccessAlert: true,
                    autoClose: form.dataset.autoClose === 'true'
                };

                options = { ...defaultOptions, ...options };

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    this.setLoading(form, true, options.loadingText);

                    try {
                        const formData = new FormData(form);
                        const method = form.method || 'POST';
                        const action = form.action || window.location.href;

                        // Convert FormData to JSON for non-GET requests
                        let body;
                        let headers = {
                            'X-Requested-With': 'XMLHttpRequest'
                        };

                        if (form.enctype === 'multipart/form-data') {
                            body = formData;
                        } else {
                            headers['Content-Type'] = 'application/json';
                            body = JSON.stringify(Object.fromEntries(formData.entries()));
                        }

                        const response = await fetch(action, {
                            method: method,
                            headers: headers,
                            body: method.toUpperCase() === 'GET' ? null : body
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            if (options.showSuccessAlert && window.Swal) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: result.message || options.successMessage,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }

                            if (options.autoClose) {
                                const modalId = form.closest('.hs-overlay').id;
                                setTimeout(() => {
                                    this.close(modalId);
                                }, options.showSuccessAlert ? 1500 : 0);
                            }

                            if (options.onSuccess) {
                                options.onSuccess(result);
                            }

                        } else if (response.status === 422) {
                            // Validation errors
                            this.showValidationErrors(form, result.errors || {});

                            if (options.onValidationError) {
                                options.onValidationError(result.errors);
                            }

                        } else {
                            // Other errors
                            if (window.Swal) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: result.message || 'An error occurred',
                                    icon: 'error'
                                });
                            }

                            if (options.onError) {
                                options.onError(result);
                            }
                        }

                    } catch (error) {
                        console.error('Form submission error:', error);

                        if (window.Swal) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Network error occurred',
                                icon: 'error'
                            });
                        }

                        if (options.onError) {
                            options.onError(error);
                        }
                    } finally {
                        this.setLoading(form, false);
                    }
                });
            }
        };

        // Handle form modal cancel
        function handleFormModalCancel(formId, modalId) {
            const form = document.getElementById(formId);
            if (form && form.dataset.resetOnClose === 'true') {
                form.reset();
                formModalUtils.clearValidation(form);
            }
        }

        // Auto-clear validation on input change
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('border-red-500')) {
                e.target.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                e.target.classList.add('border-gray-200', 'focus:border-blue-500', 'focus:ring-blue-500');

                const feedback = e.target.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = '';
                    feedback.classList.add('hidden');
                }
            }
        });

        // Store original button text
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.submit-btn .btn-text').forEach(btnText => {
                btnText.dataset.originalText = btnText.textContent;
            });
        });
    </script>
    @endpush
@endonce
