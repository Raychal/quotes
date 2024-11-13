<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteTranslation extends Model
{
    use HasFactory;

    protected $table = 'quote_translations';

    protected $fillable = [
        'quote_id',
        'language',
        'content'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id', 'id');
    }
}
