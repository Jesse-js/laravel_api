<?php

namespace App\Filters;

use DeepCopy\Exception\PropertyException;
use Exception;
use Illuminate\Http\Request;

abstract class Filter
{
    protected array $allowedOperators = [];

    protected array $translations = [
        'gte' => '>=',
        'lte' => '<=',
        'gt' => '>',
        'lt' => '<',
        'eq' => '=',
        'ne' => '!=',
        'in' => 'in',
        'not_in' => 'not in',
    ];

    public function filter(Request $request): array
    {
        $where = [];
        $whereIn = [];

        if (empty($this->allowedOperators)) {
            throw new PropertyException('Property allowedOperators is empty');
        }

        foreach ($this->allowedOperators as $param => $operators) {
            $queryOperators = $request->query($param);
            if ($queryOperators) {
                foreach ($queryOperators as $operator => $value) {
                    if (!in_array($operator, $operators)) {
                        throw new Exception("'{$param}' with operator '{$operator}' is not allowed");
                    }

                    if (str_contains($value, '[')) {
                        $whereIn[] = [
                            $param,
                            explode(',', str_replace(['[', ']'], ['', ''], $value)),
                        ];
                    } else {
                        $where[] = [$param, $this->translations[$operator], $value];
                    }
                }
            }
        }

        if (empty($where) && empty($whereIn)) {
            return [];
        }

        return [
            'where' => $where,
            'whereIn' => $whereIn
        ];
    }
}
