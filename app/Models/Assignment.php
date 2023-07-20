<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'evaluator_id', 'admin_comments', 'admin_remarks', 'evaluator_comments', 'evaluator_remarks', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Evaluator::class);
    }
}
