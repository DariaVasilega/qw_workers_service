<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * @property int $id
 * @property string $email
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $dob
 * @property \Illuminate\Database\Eloquent\Collection $positions
 * @property int|null $current_position_id
 * @property PositionHistory $position
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @inheritDoc
     */
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    protected $table = 'user';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'email',
        'firstname',
        'middlename',
        'lastname',
        'dob',
    ];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'current_position_id',
    ];

    /**
     * @inheritDoc
     */
    protected $with = [
        'position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PositionHistory::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function position(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PositionHistory::class, 'id', 'current_position_id');
    }
}
