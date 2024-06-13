<?php

namespace App\Filters;

class InvoiceFilter extends Filter
{
    protected array $allowedOperators = [
        'amount' => ['gte', 'lte', 'gt', 'lt', 'eq', 'ne', 'in', 'not_in'],
        'type' => ['eq', 'ne', 'in'],
        'paid' => ['eq', 'ne'],
        'payment_date' => ['gte', 'lte', 'gt', 'lt', 'eq', 'ne', 'in', 'not_in'],
    ];
}
