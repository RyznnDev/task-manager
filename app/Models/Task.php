<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;
  //kolom yang boleh diisi oleh form
  protected $fillable = [
      'title',
      'description',
      'task_date',
      'is_completed'
    ];
}
