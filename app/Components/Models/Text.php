<?php

namespace App\Components\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = ['text_data','titel', 'user_id','html_data'];
}
