<?php

namespace App\JsonApi;

use CloudCreativity\LaravelJsonApi\Document\Error;
use CloudCreativity\LaravelJsonApi\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

/**
 * Trait FiltersResources.
 *
 * @property Model model
 */
trait FiltersResources
{
    protected function filter($query, Collection $filters)
    {
        foreach ($filters as $name => $value) {
            $this->doFilter($query, $this->model, $name, $value);
        }
    }

    private function doFilter(Builder $query, $model, $filter, $value)
    {
        if (is_numeric($filter)) {
            foreach ($value as $key => $val) {
                $this->doFilter($query, $model, $key, $val);
            }
        } elseif (strtolower($filter) === 'or') {
            foreach ($value as $key => $val) {
                $query->orWhere(function ($query) use ($model, $key, $val) {
                    $this->doFilter($query, $model, $key, $val);
                });
            }
        } elseif (strtolower($filter) === 'and') {
            foreach ($value as $key => $val) {
                $query->where(function ($query) use ($model, $key, $val) {
                    $this->doFilter($query, $model, $key, $val);
                });
            }
        } elseif (strpos($filter, '.')) {
            $filterTableName = reset(explode('.', $filter));
            $filterName = null;
            $needle = '.';
            $pos = strpos($filter, $needle);

            if ($pos !== false) {
                $filterName = substr($filter, $pos + 1);
            }

            $incModel = $model->{$filterTableName}()->getRelated();
            $query->whereHas($filterTableName, function ($query) use ($incModel, $filterName, $value) {
                $this->doFilter($query, $incModel, $filterName, $value);
            });
        } else {
            $params = explode('__', $filter);
            $operator = null;
            $name = null;

            if (count($params) == 1) {
                $name = $params[0];
            } elseif (count($params) == 2) {
                $name = $params[0];
                $operator = $params[1];
            } else {
                throw new ValidationException(Error::create([
                    'status' => 422,
                    'title'  => 'Unknown value passed for filter',
                    'detail' => "Unknown value {{$name}}",
                    'source' => ['parameter' => "filter[{$name}]=$value"],
                ]));
            }

            $name = $this->modelKeyForField($name, $model);

            if (!Schema::connection($this->model->getConnectionName())->hasColumn($this->model->getTable(), $name)) {
                throw new ValidationException(Error::create([
                    'status' => 422,
                    'title'  => "Unknown key passed for filter: {$name}",
                ]));
            }

            $this->applyFilter($query, $operator, $name, $value);
        }
    }

    private function applyFilter(Builder $filterQuery, $operator, $name, $value)
    {
        switch ($operator) {
            case null:
            case 'is':
                if (in_array(strtolower($value), ['true', 'false', '0', '1'])) {
                    $filterQuery->where($name, filter_var($value, FILTER_VALIDATE_BOOLEAN));
                } else {
                    $filterQuery->where($name, $value);
                }
                break;
            case 'isnot':
            case 'not':
                $filterQuery->where($name, '!=', $value);
                break;

            case 'gte':
                $filterQuery->where($name, '>=', $value);
                break;
            case 'lte':
                $filterQuery->where($name, '<=', $value);
                break;
            case 'gt':
                $filterQuery->where($name, '>', $value);
                break;
            case 'lt':
                $filterQuery->where($name, '<', $value);
                break;
            case 'isnull':
                $filterQuery->whereNull($name);
                break;
            case 'null':
                if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                    $filterQuery->whereNull($name);
                } else {
                    $filterQuery->whereNotNull($name);
                }
                break;
            case 'notnull':
                $filterQuery->whereNotNull($name);
                break;
            case 'excludes':
            case 'notin':
                $items = is_array($value) ? $value : explode(',', $value);
                $filterQuery->whereNotIn($name, $items);
                break;
            case 'in':
            case 'includes':
                $items = is_array($value) ? $value : explode(',', $value);
                $filterQuery->whereIn($name, $items);
                break;
            case 'contains':
            case 'like':
                $filterQuery->where($name, 'like', "%{$value}%");
                break;
            case 'starts':
                $filterQuery->where($name, 'like', "{$value}%");
                break;
            case 'ends':
                $filterQuery->where($name, 'like', "%{$value}");
                break;
            case 'icontains':
                $filterQuery->where($name, 'COLLATE UTF8_GENERAL_CI like', "%{$value}%");
                break;
            case 'istarts':
                $filterQuery->where($name, 'COLLATE UTF8_GENERAL_CI like', "{$value}%");
                break;
            case 'iends':
                $filterQuery->where($name, 'COLLATE UTF8_GENERAL_CI like', "%{$value}");
                break;
        }
    }
}
