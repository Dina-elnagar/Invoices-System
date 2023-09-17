<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Database\Eloquent\SoftDeletes;
class invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section',
        'amount_collection',
        'amount_commission',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'value_status',
        'note',
        'payment_date',
        'user',
    ];
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section');
    }

    protected $dates = ['deleted_at'];
}
