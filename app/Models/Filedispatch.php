<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Filedispatch extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'files';

    protected $fillable = [
        'contractor_id',
        'file_number',
        'category_id',
        'category_name',
        'received_by',
        'date_received',
        'description',
        'sent_from',
        'sent_to',
        'treated',
        'date_treated',
        'treated_by',
        'user_id',
        'dispatched',
        'date_dispatched',
        'dispatch_phone',
        'dispatch_email',
        'dispatched_by',
        'dispatch_note',
    ];
    protected $casts = [
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['description', 'contractor_id', 'amount', 'treated', 'treated_by', 'dispatched', 'dispatch_note'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
