<?php 

namespace App\Enums;

enum InvoiceTypeEnum: string
{
    case CREDIT_CARD = 'C';
    case TICKET = 'B';
    case PIX = 'P';

    public function label(): string
    {
        return match ($this) {
            self::CREDIT_CARD => 'Cartão de Credito',
            self::TICKET => 'Boleto',
            self::PIX => 'Pix',
        };
    }
}