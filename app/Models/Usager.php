<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usager extends Model
{
    protected $fillable = [
        'nom',
        'cin',
        'email',
        'telephone',
        'nombre_operations',
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
