<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Contractor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class File extends Model
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use Searchable;
    protected $fillable = [
        'contractor_id',
        'file_number',
        'category_id',
        'category_name',
        'received_by',
        'date_received',
        'doc_author',
        'doc_sender',
        'amount',
        'description',
        'email',
        'phone',
        'hand_carried',
        'retrieved_by',
        'date_retrieved',
        'treated',
        'date_treated',
        'treated_by',
        'user_id',
        'notes',
        'remarks',
        'date_dispatched',
        'sent_from',
        'sent_to',
        'dispatch_phone',
        'dispatch_email',
        'dispatched_by',
        'dispatch_remarks',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'contractor_id',
                'file_number',
                'category_id',
                'category_name',
                'received_by',
                'date_received',
                'doc_author',
                'doc_sender',
                'amount',
                'description',
                'email',
                'phone',
                'hand_carried',
                'retrieved_by',
                'date_retrieved',
                'treated',
                'date_treated',
                'treated_by',
                'user_id',
                'notes',
                'remarks',
                'date_dispatched',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


}
