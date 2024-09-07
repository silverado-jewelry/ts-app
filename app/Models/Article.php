<?php

namespace App\Models;

use App\Events\ArticleEventCreating;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property \Illuminate\Support\Carbon $publish_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \App\Models\User $user
 */
class Article extends Model
{
    use HasFactory, HasTimestamps;

    /** @var string[] */
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'publish_at'
    ];

    /** @var string[] */
    protected $casts = [
        'publish_at' => 'datetime'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
