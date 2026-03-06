<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $menuId = $this->route('menu') ?? $this->input('menu_id');

        return [
            'parent_id' => [
                'nullable',
                'uuid',
                Rule::exists('menus', 'id')->where('is_active', true),
                // Jangan boleh set menu sebagai parent dari dirinya sendiri
                Rule::notIn([$menuId]),
            ],

            'type' => [
                'required',
                'string',
                Rule::in(['item', 'dropdown']),
            ],

            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'icon' => [
                'nullable',
                'string',
                'max:150',
            ],

            'color' => [
                'nullable',
                'string',
                'max:30',
            ],

            'menu_key' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('menus', 'menu_key')
                    ->ignore($menuId, 'id')
                    ->when($this->input('type') === 'dropdown', function ($rule) {
                        return $rule->whereNull('deleted_at');
                    }),
            ],

            'route' => [
                'nullable',
                'string',
                'max:200',
                'required_if:type,item',
            ],

            'url' => [
                'nullable',
                'string',
                'max:255',
                'url',
            ],

            'order_no' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'badge' => [
                'nullable',
                'string',
                'max:100',
            ],

            'badge_color' => [
                'nullable',
                'string',
                'max:30',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            // Permissions
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*.role_code' => [
                'required_with:permissions',
                'string',
                'max:50',
            ],
            'permissions.*.can_view' => [
                'nullable',
                'boolean',
            ],
            'permissions.*.can_create' => [
                'nullable',
                'boolean',
            ],
            'permissions.*.can_edit' => [
                'nullable',
                'boolean',
            ],
            'permissions.*.can_delete' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul menu wajib diisi',
            'title.max' => 'Judul menu maksimal 150 karakter',
            'type.required' => 'Tipe menu wajib diisi',
            'type.in' => 'Tipe menu harus item atau dropdown',
            'route.required_if' => 'Route wajib diisi jika tipe menu adalah item',
            'menu_key.unique' => 'Menu key sudah digunakan',
            'parent_id.exists' => 'Parent menu tidak valid',
            'parent_id.not_in' => 'Menu tidak bisa menjadi parent dari dirinya sendiri',
            'url.url' => 'URL harus format yang valid',
        ];
    }

    /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'parent_id' => 'Menu Parent',
            'type' => 'Tipe Menu',
            'title' => 'Judul Menu',
            'icon' => 'Icon',
            'color' => 'Warna',
            'menu_key' => 'Menu Key',
            'route' => 'Route',
            'url' => 'URL',
            'order_no' => 'Urutan',
            'description' => 'Deskripsi',
            'badge' => 'Badge',
            'badge_color' => 'Warna Badge',
            'is_active' => 'Aktif',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default order_no jika tidak ada
        if (!$this->has('order_no') || $this->input('order_no') === '') {
            $this->merge(['order_no' => 0]);
        }

        // Set is_active ke false jika tidak di-check
        if (!isset($this->input()['is_active'])) {
            $this->merge(['is_active' => false]);
        }
    }
}
