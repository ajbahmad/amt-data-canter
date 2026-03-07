<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardHistoryRequest extends FormRequest
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
        return [
            'id_card_id' => 'required|uuid|exists:id_cards,id',
            'person_id' => 'required|uuid|exists:persons,id',
            'action' => 'required|in:issued,blocked,lost,replaced,unblocked,expired',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'id_card_id.required' => 'ID Card wajib dipilih',
            'id_card_id.uuid' => 'ID Card tidak valid',
            'id_card_id.exists' => 'ID Card tidak ditemukan',
            'person_id.required' => 'Person wajib dipilih',
            'person_id.uuid' => 'Person tidak valid',
            'person_id.exists' => 'Person tidak ditemukan',
            'action.required' => 'Tindakan wajib dipilih',
            'action.in' => 'Tindakan tidak valid',
            'notes.max' => 'Catatan maksimal 1000 karakter',
        ];
    }
}
