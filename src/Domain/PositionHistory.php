<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * @property int $id
 * @property int $user_id
 * @property string $position_code
 * @property float $salary
 * @property string $from_date
 * @property Position $position
 * @property User $user
 */
class PositionHistory extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @inheritDoc
     */
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    protected $table = 'position_history';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'user_id',
        'position_code',
        'salary',
        'from_date',
    ];

    /**
     * @inheritDoc
     */
    protected $with = [
        'position'
    ];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'position_code'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function position(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Position::class, 'code', 'position_code');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
