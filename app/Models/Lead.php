<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id','assigned_to','created_by','title','contact_name',
        'contact_email','contact_phone','source','status','value',
        'expected_close','notes','lost_reason',
    ];

    protected $casts = [
        'value' => 'float',
        'expected_close' => 'date',
    ];

    const STATUS_NEW = 'new';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_QUALIFIED = 'qualified';
    const STATUS_PROPOSAL = 'proposal';
    const STATUS_NEGOTIATION = 'negotiation';
    const STATUS_WON = 'won';
    const STATUS_LOST = 'lost';

    const STATUSES = [
        self::STATUS_NEW => ['label' => 'New', 'color' => 'gray'],
        self::STATUS_CONTACTED => ['label' => 'Contacted', 'color' => 'blue'],
        self::STATUS_QUALIFIED => ['label' => 'Qualified', 'color' => 'cyan'],
        self::STATUS_PROPOSAL => ['label' => 'Proposal', 'color' => 'yellow'],
        self::STATUS_NEGOTIATION => ['label' => 'Negotiation', 'color' => 'orange'],
        self::STATUS_WON => ['label' => 'Won', 'color' => 'green'],
        self::STATUS_LOST => ['label' => 'Lost', 'color' => 'red'],
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class)->latest('occurred_at');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeForAgent(Builder $q, User $user): Builder
    {
        if ($user->role === 'agent') {
            return $q->where('assigned_to', $user->id);
        }
        return $q;
    }

    public function scopeByStatus(Builder $q, ?string $status): Builder
    {
        return $status ? $q->where('status', $status) : $q;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? ucfirst($this->status);
    }
}