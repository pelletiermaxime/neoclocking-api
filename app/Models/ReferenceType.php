<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceType extends Model
{
    const CODE_REDMINE = 'redmine';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reference_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'prefix',
    ];
}
