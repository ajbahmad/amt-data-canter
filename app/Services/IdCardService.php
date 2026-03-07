<?php

namespace App\Services;

use App\Models\IdCard;
use App\Models\CardHistory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class IdCardService
{
    /**
     * Get all ID cards with pagination
     */
    public function getAll($perPage = 10, $search = null)
    {
        $query = IdCard::with('person');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('card_uid', 'like', "%{$search}%")
                    ->orWhere('card_number', 'like', "%{$search}%")
                    ->orWhereHas('person', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get ID card by ID
     */
    public function getById($id)
    {
        return IdCard::with('person', 'history')->findOrFail($id);
    }

    /**
     * Create new ID card
     */
    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $idCard = IdCard::create($data);
    
            // Create initial history record (issued)
            CardHistory::create([
                'id_card_id' => $idCard->id,
                'person_id' => $idCard->person_id,
                'action' => 'issued',
                'notes' => 'Kartu ID dikeluarkan',
            ]);
    
            return $idCard->load('person');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update ID card
     */
    public function update($id, array $data)
    {
        $idCard = IdCard::findOrFail($id);

        // Track status changes
        $oldStatus = $idCard->status;
        $newStatus = $data['status'] ?? $oldStatus;

        $idCard->update($data);

        // Create history record if status changed
        if ($oldStatus !== $newStatus) {
            CardHistory::create([
                'id_card_id' => $idCard->id,
                'person_id' => $idCard->person_id,
                'action' => $newStatus,
                'notes' => "Status berubah dari {$oldStatus} menjadi {$newStatus}",
            ]);
        }

        return $idCard->load('person');
    }

    /**
     * Delete ID card
     */
    public function delete($id)
    {
        $idCard = IdCard::findOrFail($id);

        return $idCard->delete();
    }

    /**
     * Get cards by person
     */
    public function getByPerson($personId)
    {
        return IdCard::where('person_id', $personId)
            ->with('person', 'history')
            ->get();
    }

    /**
     * Get cards by status
     */
    public function getByStatus($status)
    {
        return IdCard::where('status', $status)
            ->with('person')
            ->get();
    }

    /**
     * Get active cards
     */
    public function getActiveCards()
    {
        return IdCard::active()
            ->with('person')
            ->get();
    }

    /**
     * Record history
     */
    public function recordHistory($idCardId, $action, $notes = null)
    {
        $idCard = IdCard::findOrFail($idCardId);

        return CardHistory::create([
            'id_card_id' => $idCardId,
            'person_id' => $idCard->person_id,
            'action' => $action,
            'notes' => $notes,
        ]);
    }

    /**
     * Get history for a card
     */
    public function getHistory($idCardId, $limit = 10)
    {
        return CardHistory::where('id_card_id', $idCardId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if card UID exists
     */
    public function cardUidExists($cardUid, $excludeId = null)
    {
        $query = IdCard::where('card_uid', $cardUid);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        return [
            'total' => IdCard::count(),
            'active' => IdCard::where('status', 'active')->count(),
            'lost' => IdCard::where('status', 'lost')->count(),
            'blocked' => IdCard::where('status', 'blocked')->count(),
            'expired' => IdCard::where('status', 'expired')->count(),
        ];
    }
}
