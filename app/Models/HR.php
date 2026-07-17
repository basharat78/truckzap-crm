<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HR extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'phone',
            'email',
            'position',
            'department',
            'expected_salary',
            'experience',
            'city',
            'reference',
            'interviewer',
            'interview_date',
            'communication',
            'english',
            'computer_skills',
            'confidence',
            'learning_ability',
            'dispatch_knowledge',
            'negotiation_skills',
            
            'typing_speed',
            'total_score',
            'strengths',
            'weaknesses',
            'comments',
            'recommendation',
            'status'
    ] ;
}
