<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'usager_id',
        'operation_type_id',
    ];

    public function usager()
    {
        return $this->belongsTo(Usager::class);
    }

    public function operationType()
    {
        return $this->belongsTo(OperationType::class);
    }
}
