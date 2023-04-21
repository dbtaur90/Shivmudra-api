<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SabhasadVerificationModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbSabhasadVerification';

    protected $casts = [
        'basicVerification' => 'boolean',
        'documentVerification' => 'boolean',
        'photoSignVerification' => 'boolean',
    ];
    /**
 * The attributes that aren't mass assignable.
 *
 * @var array
 */
   protected $guarded = [];
}
