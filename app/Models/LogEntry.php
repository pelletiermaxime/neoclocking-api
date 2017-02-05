<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ModelOperationDeniedException;


class LogEntry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'started_at',
        'ended_at',
        'validated',
        'comment',
        'clocking_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'ended_at',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function (LogEntry $logEntry) {
            if ($logEntry->validated) {
                throw new ModelOperationDeniedException('Impossible de supprimer un log validé');
            }
        });

        static::saved(function (LogEntry $logEntry) {
            $logEntry->task->touch();
            if (!empty($logEntry->getOriginal('task_id'))
                && $logEntry->getOriginal('task_id') !== $logEntry->task_id
            ) {
                Task::find($logEntry->getOriginal('task_id'))->touch();
            }
        });

        static::deleted(function (LogEntry $logEntry) {
            $logEntry->task->touch();
        });
    }

    /**
     * Get related task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get related user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the user and the hourly cost of the user.
     *
     * @param User $user
     */
    protected function setUserAttribute(User $user)
    {
        /*
        *  Prevent changing user and hourly_cost if the log has already been saved.
        *  Changer le user nécéssiterait de changer le hourly_cost, qui pourrait ne plus être identique
        *  à celui qui était effectif au moment de la création du log. (Garder cette explication!)
        */
        if (!$this->exists) {
            $this->attributes['user_id'] = $user->id;
            $this->attributes['hourly_cost'] = $user->hourly_cost;
        }
    }

    /**
     * @return bool True if log isn't closed (no end)
     */
    public function isOngoing()
    {
        $end = $this->ended_at;
        return (is_null($end) == true);
    }

    /**
     * Check if this log entry overlaps another; for this user
     *
     * @return LogEntry[]
     */
    public function overlapsAnother()
    {
        /**
         * Get overlapping logs for this user with the tsrange function on the index we created
         * The parenthesises/brackets syntax for defining bounds is slightly confusing
         * The square brackets are inclusive and parenthesises are exclusive.
         * Thus '[)' includes the start and excludes the end.
         * This prevents 13:00 - 14:00 and 14:00 - 15:00 from being considered as overlapping.
         * More info here: http://www.postgresql.org/docs/9.4/static/rangetypes.html
         */
        return LogEntry::whereUserId(user()->id)
            ->where('id', '<>', $this->id)
            ->whereRaw(
                "tsrange(started_at, ended_at, '[)') && tsrange('{$this->started_at}', '{$this->ended_at}')"
            )->exists();
    }

    /**
     * @param string $comment
     */
    public function setCommentAttribute($comment)
    {
        if (empty($comment)) {
            // Avoid empty strings for easier reuse of data
            $comment = null;
        }
        $this->attributes['comment'] = $comment;
    }

    public function getTimeAttribute()
    {
        return $this->ended_at->diffInMinutes($this->started_at);
    }
}
