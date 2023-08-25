<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Accounts extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Address',
        'ContactNumber',
        'BirthDate',
        'Gender',
        'email',
        'password',
        'AccessType'
    ];

    public function setPasswordAttribute($value) {
        if (Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }
        $this->attributes["password"] = $value;
    }
}
