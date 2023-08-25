<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * @property int $id
 * @property int $user_id
 * @property string $position_code
 * @property float $salary
 * @property string $from_date
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
}
