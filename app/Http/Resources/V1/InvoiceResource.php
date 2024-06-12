<?php

namespace App\Http\Resources\V1;

use App\Enums\InvoiceTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'firstName' => $this->user->firstName,
                'lastName' => $this->user->lastName,
                'fullName' => $this->user->firstName . ' ' . $this->user->lastName,
                'email' => $this->user->email,
            ],
            'type' => InvoiceTypeEnum::from($this->type)->label(),
            'amount' => 'R$'. number_format($this->amount, 2, '.', ','),
            'paid' => $this->paid ? 'Pago' : 'Pendente',
            'payment_date' => $this->paid ? Carbon::parse($this->payment_date)->format('d/m/Y H:i:s') : null,
            'payment_since' => $this->paid ? Carbon::parse($this->payment_date)->diffForHumans() : null,
        ];
    }
}
