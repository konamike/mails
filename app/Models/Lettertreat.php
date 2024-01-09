<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Lettertreat extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'letters';

    protected $fillable = [
        'doc_author',
        'file_number',
        'category_id',
        'contractor_id',
        'description',
        'amount',
        'received_by',
        'date_received',
        'hand_carried',
        'retrieved_by',
        'date_retrieved',
        'treated',
        'date_treated',
        'treated_by',
        'treated_note',
        'date_dispatched',
        'dispatch_phone',
        'dispatch_email',
        'dispatched_by',
        'dispatch_note',
        'dispatched',
        'sent_to',
        'sent_from',
        'remarks',
        'user_id',
    ];


    protected $casts = [
        'date_received' => 'date',
        'date_treated' => 'date',
        'treated' => 'boolean',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['description', 'contractor_id', 'amount', 'treated', 'treated_note', 'treated_by', 'dispatched', 'dispatch_note'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
