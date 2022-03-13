<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter (Builder $query, $parameters)
    {
        foreach ($parameters as $field => $parameterValue)
        {
            $method = 'filter' . Str::studly($field);

            if (method_exists($this, $method))
            {
                $this->$method($query, $parameterValue);
                return;
            }

            if (in_array($field, ['limit', 'offset']))
            {
                $this->_limitOffset($query, $field, $parameterValue);
            }

            if (!is_array($parameterValue))
            {
                continue;
            }

            foreach ($parameterValue as $operator => $value)
            {
                if ($operator != 'sort')
                {
                    $this->_where($query, $field, $operator, $value);
                }
                else
                {
                    $this->_orderBy($query, $field, $value);
                }
            }
        }
    }

    private function _where (Builder $query, $field, $operator, $value)
    {
        if ($value == 'all')
        {
            return;
        }

        if (empty($this->filterable) || !is_array($this->filterable))
        {
            return;
        }

        if (key_exists($field, $this->filterable))
        {
            $field = $this->filterable[$field];
        }

        $method = 'where';
        if (strpos($operator, '|') !== false)
        {
            $operator = str_replace('|', '', $operator);
            $method   = 'orWhere';
        }
        $operator = str_replace('equal', '=', $operator);

        if (in_array($field, $this->filterable))
        {
            switch ($operator)
            {
                case 'between':
                    $query->{$method . 'Between'}("{$this->table}.{$field}", explode(',', $value));
                    break;
                case 'in':
                    $query->{$method . 'In'}("{$this->table}.{$field}", explode(',', $value));
                    break;
                case 'not in':
                    $query->{$method . 'NotIn'}("{$this->table}.{$field}", explode(',', $value));
                    break;
                case 'like':
                    $query->{$method}("{$this->table}.{$field}", 'like', $value);
                    break;
                case 'not like':
                    $query->{$method}("{$this->table}.{$field}", 'not like', $value);
                    break;
                case 'null':
                    $query->{$method . 'Null'}("{$this->table}.{$field}");
                    break;
                case 'not null':
                    $query->{$method . 'NotNull'}("{$this->table}.{$field}");
                    break;
                default:
                    $query->{$method}("{$this->table}.{$field}", $operator, $value);
            }
        }
    }

    private function _orderBy (Builder $query, $field, $value)
    {
        if (empty($this->sortable) || !is_array($this->sortable))
        {
            return;
        }

        if (key_exists($field, $this->sortable))
        {
            $field = $this->sortable[$field];
        }

        if (in_array($field, $this->sortable))
        {
            $query->orderBy($field, $value);
        }
    }

    private function _limitOffset (Builder $query, string $field, string $value)
    {
        $query->{$field}($value);
    }
}