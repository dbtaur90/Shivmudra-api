<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SabhasadModel;

class SabhasadEmploymentModel extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbSabhasadEmployment';
    
     protected $casts = [
        'isAgricultureCumBusiness' => 'boolean',
    ];
    
     public function sabhasad()
    {
        return $this->belongsTo(SabhasadModel::class);
    }

    /**
 * The attributes that aren't mass assignable.
 *
 * @var array
 */
protected $guarded = [];
}
