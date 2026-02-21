@props([
    'id' => 'confirmModal',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to perform this action?',
    'icon' => 'warning', // warning, danger, info, success, question
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmColor' => 'red', // red, blue, green, yellow, purple, gray
    'size' => 'md',
    'showIcon' => true,
    'persistent' => false, // Prevent closing unless user clicks button
])

@php
    $iconClasses = [
        'warning' => 'ti-alert-triangle text-yellow-500',
        'danger' => 'ti-alert-circle text-red-500',
        'info' => 'ti-info-circle text-blue-500',
        'success' => 'ti-check-circle text-green-500',
        'question' => 'ti-help-circle text-purple-500',
    ];

    $confirmColorClasses = [
        'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        'blue' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        'green' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
        'yellow' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500',
        'purple' => 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500',
        'gray' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500',
    ];

    $iconClass = $iconClasses[$icon] ?? $iconClasses['warning'];
    $confirmColorClass = $confirmColorClasses[$confirmColor] ?? $confirmColorClasses['red'];
@endphp

<x-modal :id="$id"
         :title="$title"
         :size="$size"
         :show-footer="true"
         :backdrop="!$persistent"
         :keyboard="!$persistent"
         :static="$persistent"
         centered="true">

    <div class="p-6 text-center">
        @if($showIcon)
            <div class="mb-4">
                <i class="{{ $iconClass }} text-6xl mx-auto"></i>
            </div>
        @endif

        <div class="mb-6">
            @if(is_string($message))
                <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                    {{ $message }}
                </p>
            @else
                {{ $message }}
            @endif
        </div>

        {{ $slot }}
    </div>

    <x-slot name="footer">
        <button type="button"
            class="py-2 px-4 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-gray-600 dark:focus:ring-offset-gray-800 transition-colors duration-150 cancel-btn"
            onclick="handleConfirmModalCancel('{{ $id }}')">
            {{ $cancelText }}
        </button>

        <button type="button"
            class="py-2 px-4 text-sm font-medium rounded-lg border border-transparent {{ $confirmColorClass }} text-white disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-150 confirm-btn"
            onclick="handleConfirmModalConfirm('{{ $id }}')">
            <span class="inline-block size-4 animate-spin border-[3px] border-current border-t-transparent text-white rounded-full hidden loading-spinner"
                  role="status"
                  aria-label="loading">
            </span>
            <span class="btn-text">{{ $confirmText }}</span>
        </button>
    </x-slot>
</x-modal>

@once
    @push('scripts')
    <script>
        // Confirmation Modal Utilities
        window.confirmModalUtils = {

            // Show confirmation modal
            show: function(options = {}) {
                const defaultOptions = {
                    id: 'confirmModal',
                    title: 'Confirm Action',
                    message: 'Are you sure you want to perform this action?',
                    icon: 'warning',
                    confirmText: 'Confirm',
                    cancelText: 'Cancel',
                    confirmColor: 'red',
                    onConfirm: null,
                    onCancel: null,
                    showLoading: true,
                    autoClose: true,
                    data: null
                };

                options = { ...defaultOptions, ...options };

                // Create dynamic modal if it doesn't exist
                if (!document.getElementById(options.id)) {
                    this.createDynamicModal(options);
                }

                const modal = document.getElementById(options.id);

                // Update modal content
                this.updateModalContent(modal, options);

                // Store options for later use
                modal._confirmOptions = options;

                // Open modal
                modalUtils.open(options.id);

                return options.id;
            },

            // Create dynamic modal
            createDynamicModal: function(options) {
                const modalHtml = `
                    <x-confirm-modal
                        id="${options.id}"
                        title="${options.title}"
                        message="${options.message}"
                        icon="${options.icon}"
                        confirm-text="${options.confirmText}"
                        cancel-text="${options.cancelText}"
                        confirm-color="${options.confirmColor}"
                    />
                `;

                // This would need to be handled differently in a real implementation
                // For now, we'll assume the modal exists in the page
            },

            // Update modal content
            updateModalContent: function(modal, options) {
                const titleElement = modal.querySelector('h3');
                if (titleElement) titleElement.textContent = options.title;

                const messageElement = modal.querySelector('.text-gray-600, .text-gray-300');
                if (messageElement) messageElement.textContent = options.message;

                const confirmBtn = modal.querySelector('.confirm-btn .btn-text');
                if (confirmBtn) confirmBtn.textContent = options.confirmText;

                const cancelBtn = modal.querySelector('.cancel-btn');
                if (cancelBtn) cancelBtn.textContent = options.cancelText;
            },

            // Set loading state
            setLoading: function(modalId, loading = true) {
                const modal = document.getElementById(modalId);
                const confirmBtn = modal.querySelector('.confirm-btn');
                const spinner = confirmBtn.querySelector('.loading-spinner');
                const btnText = confirmBtn.querySelector('.btn-text');

                if (loading) {
                    confirmBtn.disabled = true;
                    spinner.classList.remove('hidden');
                } else {
                    confirmBtn.disabled = false;
                    spinner.classList.add('hidden');
                }
            },

            // Handle confirm
            confirm: function(modalId) {
                const modal = document.getElementById(modalId);
                const options = modal._confirmOptions;

                if (options && options.onConfirm) {
                    if (options.showLoading) {
                        this.setLoading(modalId, true);
                    }

                    // Call the confirm callback
                    const result = options.onConfirm(options.data);

                    // If it's a promise, handle it
                    if (result instanceof Promise) {
                        result
                            .then(() => {
                                if (options.autoClose) {
                                    modalUtils.close(modalId);
                                }
                            })
                            .catch((error) => {
                                console.error('Confirm action failed:', error);
                            })
                            .finally(() => {
                                this.setLoading(modalId, false);
                            });
                    } else {
                        this.setLoading(modalId, false);
                        if (options.autoClose) {
                            modalUtils.close(modalId);
                        }
                    }
                } else {
                    modalUtils.close(modalId);
                }
            },

            // Handle cancel
            cancel: function(modalId) {
                const modal = document.getElementById(modalId);
                const options = modal._confirmOptions;

                if (options && options.onCancel) {
                    options.onCancel(options.data);
                }

                modalUtils.close(modalId);
            }
        };

        // Global handlers for confirmation modal buttons
        function handleConfirmModalConfirm(modalId) {
            confirmModalUtils.confirm(modalId);
        }

        function handleConfirmModalCancel(modalId) {
            confirmModalUtils.cancel(modalId);
        }

        // Convenience function for quick confirmations
        window.confirm = function(message, onConfirm, options = {}) {
            return confirmModalUtils.show({
                message: message,
                onConfirm: onConfirm,
                ...options
            });
        };

        // SweetAlert2 style API
        window.confirmDialog = {
            fire: function(options) {
                if (typeof options === 'string') {
                    options = { message: options };
                }

                return new Promise((resolve, reject) => {
                    const modalId = confirmModalUtils.show({
                        ...options,
                        onConfirm: () => resolve(true),
                        onCancel: () => resolve(false)
                    });
                });
            }
        };
    </script>
    @endpush
@endonce
