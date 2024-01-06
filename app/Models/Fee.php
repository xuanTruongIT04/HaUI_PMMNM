<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model {

    use HasFactory;
    protected $guarded = [];
    protected $table = 'fees';

    public function medicalRegistrationForm() {
        return $this->belongsTo(MedicalRegistrationForm::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}