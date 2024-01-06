<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRegistrationForm extends Model
{
    use HasFactory;
    protected $table = 'medical_registration_forms';
    protected $guarded = [];

    public function doctor() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function fees() {
        return $this->hasMany(Fee::class);
    }
}
