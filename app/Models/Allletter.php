<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allletter extends Model
{
    use HasFactory;

    protected $table = 'letters';
    protected $fillable = [
        'doc_author',
        'file_number',
        'category_id',
        'contractor_id',
        'description',
        'amount',
        'phone',
        'received_by',
        'date_received',
        'hand_carried',
        'retrieved_by',
        'date_retrieved',
        'treated',
        'date_treated',
        'treated_by',
        'treated_note',
        'remarks',
        'user_id',
        'sent_from',
        'sent_to',
        'date_dispatched',
        'dispatch_phone',
        'dispatch_email',
        'dispatched_by',
        'dispatch_note',
        'dispatched',
    ];


    protected $casts = [
        'date_received' => 'date',
        'date_retrieved' => 'date',
        'date_treated' => 'date',
        'date_dispatched' => 'date',
        'treated' => 'boolean',
        'dispatched' => 'boolean'
    ];

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
