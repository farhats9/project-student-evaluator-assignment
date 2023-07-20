<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'title', 'abstract', 'keywords', 'domain_id', 'file_upload', 'docType'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function assignment()
    {
        return $this->hasOne(Assignment::class);
    }
}
