<?php

namespace App\Models;

use App\Filters\InvoiceFilter;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'paid',
        'payment_date',
        'amount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function filter(Request $request)
    {
        $queryFilter = (new InvoiceFilter)->filter($request);
        
        if (empty($queryFilter)) {
            return InvoiceResource::collection(
                Invoice::with('user')->get()
            );
        }

        $data = Invoice::with('user');

        if(!empty($queryFilter['whereIn'])) {
            foreach ($queryFilter['whereIn'] as $value) {
                $data->whereIn($value[0], $value[1]);
            }
        }

        if(!empty($queryFilter['where'])) {
            $data->where($queryFilter['where']);
        }

        return InvoiceResource::collection($data->get());
    }
}
