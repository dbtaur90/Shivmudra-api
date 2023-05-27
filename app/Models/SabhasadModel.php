<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class SabhasadModel extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbSabhasad';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'sabhasadID';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'married' => 'boolean',
        'isSameAddress' => 'boolean',
        'competitiveCandidate' => 'boolean',
        'isPoliticalBackground' => 'boolean',
        'isSocialBackground' => 'boolean',
        'workingArea' => 'boolean'

    ];

    public function educationData()
    {
        return $this->belongsTo(SabhasadEducationModel::class, 'educationID');
    }
    public function employeeData()
    {
        return $this->belongsTo(SabhasadEmploymentModel::class, 'businessID');
    }
    public function currentAddress()
    {
        return $this->belongsTo(AddressDirectory::class, 'currentVillage', 'AddressDirectoryID');
    }
    public function permanentAddress()
    {
        return $this->belongsTo(AddressDirectory::class, 'permanentVillage', 'AddressDirectoryID');
    }
    public function documentData()
    {
        return $this->hasOne(SabhasadDocumentModel::class, 'sabhasadID', 'sabhasadID');
    }
    public function verificationData()
    {
        return $this->hasOne(SabhasadVerificationModel::class, 'sabhasadID', 'sabhasadID');
    }

    public function executiveData()
    {
        return $this->hasOne(Executive::class, 'sabhasadID', 'sabhasadID');
    }
}