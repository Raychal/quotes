<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quote extends Model
{
    use HasFactory;
    protected $table = 'quotes';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'author_id',
        'category'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function scopeIsPaginate($query, $paginate)
    {
        return $paginate === true ? $query->paginate(10) : $query->get();
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function content()
    {
        return $this->hasMany(QuoteTranslation::class, 'quote_id', 'id');
    }
}
