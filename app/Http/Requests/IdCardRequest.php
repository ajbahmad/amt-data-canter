<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdCardRequest extends FormRequest
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
        $cardId = $this->route('id_card');

        return [
            'card_uid' => [
                'required',
                'string',
                'max:100',
                $cardId
                    ? "unique:id_cards,card_uid,{$cardId},id"
                    : 'unique:id_cards,card_uid',
            ],
            'card_number' => 'nullable|string|max:100',
            'person_id' => 'required|uuid|exists:persons,id',
            'status' => 'required|in:active,lost,blocked,expired',
            'issued_at' => 'nullable|date',
            'expired_at' => 'nullable|date|after_or_equal:issued_at',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'card_uid.required' => 'UID Kartu wajib diisi',
            'card_uid.unique' => 'UID Kartu sudah terdaftar',
            'card_uid.max' => 'UID Kartu maksimal 100 karakter',
            'card_number.max' => 'Nomor Kartu maksimal 100 karakter',
            'person_id.required' => 'Person wajib dipilih',
            'person_id.uuid' => 'Person tidak valid',
            'person_id.exists' => 'Person tidak ditemukan',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
            'issued_at.date' => 'Format tanggal keluaran tidak valid',
            'expired_at.date' => 'Format tanggal expired tidak valid',
            'expired_at.after_or_equal' => 'Tanggal expired harus lebih besar atau sama dengan tanggal keluaran',
        ];
    }
}
