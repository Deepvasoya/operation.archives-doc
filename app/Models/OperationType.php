<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    protected $fillable = [
        'nom',
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
