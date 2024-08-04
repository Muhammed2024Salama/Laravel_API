<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{

//<!--Searchable By Api -->

    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request)
    {
        $eloQuery = [];

        // name-eq-value
        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);
            if (!isset($query)) {
                continue;
            }
        }

        $column = $this->columnMap[$param] ?? $param;

        foreach ($operators as $operator)
            if (isset($query[$operator])) {
                $eloQuery[] = [$column, $this->operatorMap($operator), $query($operator)];
            }

        return $eloQuery;
    }
}
