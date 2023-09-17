<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'product',
        'invoice_number',
        'section',
        'status',
        'value_status',
        'note',
        'user',

    ];
    public function sections()
    {
        return $this->belongsTo(Section::class,'section');
    }
}
