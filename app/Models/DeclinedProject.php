<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeclinedProject extends Model
{
    protected $table = 'declined_projects';

    protected $fillable = [
        'project_id',
        'evaluator_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Evaluator::class);
    }
}
