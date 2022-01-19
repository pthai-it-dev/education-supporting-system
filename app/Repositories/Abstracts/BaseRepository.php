<?php

namespace App\Repositories\Abstracts;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseRepository implements BaseRepositoryContract
{
    protected $model;

    public function __construct ()
    {
        $this->createModel();
    }

    /**
     * Specify Model class name
     * @return mixed
     */
    abstract function model ();

    /**
     * @return mixed
     */
    public function createModel ()
    {
        try
        {
            $model = app()->make($this->model());
            return $this->model = $model;
        }
        catch (BindingResolutionException $e)
        {
            return null;
        }
    }

    public function insert (array $object)
    {
        $this->createModel();
        return $this->model->create($object);
    }

    public function insertGetId (array $object)
    {
        $this->createModel();
        return $this->model->create($object)->id;
    }

    public function insertMultiple (array $objects)
    {
        $this->createModel();
        $this->model->insert($objects);
    }

    public function upsert ($objects, array $uniqueColumns = [],
                            array $columnsUpdate = [])
    {
        if (empty($columnsUpdate))
        {
            $columnsUpdate['id'] = DB::raw('id');
        }

        $this->createModel();
        $this->model->upsert($objects, $uniqueColumns, $columnsUpdate);
    }

    public function update (array $values, array $conditions = [])
    {
        $this->createModel();
        $this->addWhere($conditions);
        $this->model->update();
    }

    public function updateIncrement (string $column, int $step = 1, array $conditions = [])
    {
        $this->createModel();
        $this->addWhere($conditions);
        $this->model->increment($column, $step);
    }

    public function updateByIds ($ids, $values)
    {
        $this->createModel();
        $this->model->whereIn('id', $ids)->update($values);
    }

    public function updateIncrementByIds ($ids, $column, int $step = 1)
    {
        $this->createModel();
        $this->model->whereIn('id', $ids)->increment($column, $step);
    }

    public function find (array $columns = ['*'], array $conditions1 = [], array $conditions2 = [],
                          int   $limit = null, int $offset = null, array $scopes = [],
                          array $postFunctions = [])
    {
        $this->createModel();

        $this->addScopes($scopes);
        $this->addWhere($conditions1);
        $this->addOrderBy($conditions2);

        if ($offset)
        {
            $this->model = $this->model->offset($offset);
        }

        if ($limit)
        {
            $this->model = $this->model->limit($limit);
        }

        $result = $this->model->get($columns);
        $this->addPostFunction($result, $postFunctions);

        return $result;
    }

    public function findByIds ($ids, array $columns = ['*'])
    {
        $this->createModel();
        return $this->model->find($ids, $columns);
    }

    public function delete (array $conditions = [])
    {
        $this->createModel();
        $this->addWhere($conditions);
        return $this->model->delete();
    }

    public function deleteByIds (array $ids)
    {
        $this->createModel();
        $this->model->whereIn('id', $ids)->delete();
    }

    public function count (array $conditions = [])
    {
        $this->createModel();
        $this->addWhere($conditions);
        return $this->model->count();
    }

    //    public function checkExist ($id)
    //    {
    //        //reset model
    //        $this->createModel();
    //
    //        return $this->model->find($id) ? true : false;
    //    }


    //    public function paginate ($perPage = 1, array $columns = ['*'])
    //    {
    //        //reset model
    //        $this->createModel();
    //
    //        return $this->model->paginate($perPage, $columns);
    //    }

    //    public function checkExistBy (array $condition)
    //    {
    //        //reset model
    //        $this->createModel();
    //        $this->addWhere($condition);
    //        $data = $this->model->get();
    //        if ($data->isEmpty())
    //        {
    //            return false;
    //        }
    //        else
    //        {
    //            return true;
    //        }
    //    }

    protected function addScopes (array $scopes)
    {
        if (empty($scopes))
        {
            return;
        }

        foreach ($scopes as $arr)
        {
            $scope       = array_shift($arr);
            $this->model = $this->model->$scope(...$arr);
        }
    }

    protected function addOrderBy (array $conditions = [])
    {
        if (empty($conditions))
        {
            return;
        }

        foreach ($conditions as $condition)
        {
            $attribute   = $condition[0];
            $order       = $condition[1] ?? 'asc';
            $this->model = $this->model->orderBy($attribute, $order);
        }
    }

    protected function addWhere (array $conditions = [])
    {
        if (empty($conditions))
        {
            return;
        }

        foreach ($conditions as $condition)
        {
            $attribute = $condition[0];
            $operator  = $condition[1];
            $value     = $condition[2] ?? null;

            if ($operator == "=")
            {
                $this->model = $this->model->where($attribute, "=", $value);
            }

            if ($operator == ">")
            {
                $this->model = $this->model->where($attribute, ">", $value);
            }

            if ($operator == ">=")
            {
                $this->model = $this->model->where($attribute, ">=", $value);
            }

            if ($operator == "<")
            {
                $this->model = $this->model->where($attribute, "<", $value);
            }

            if ($operator == "<=")
            {
                $this->model = $this->model->where($attribute, "<=", $value);
            }

            if ($operator == "<>")
            {
                $this->model = $this->model->where($attribute, "<>", $value);
            }

            if ($operator == "!=")
            {
                $this->model = $this->model->where($attribute, "!=", $value);
            }

            if ($operator == "in")
            {
                $this->model = $this->model->whereIn($attribute, $value);
            }

            if ($operator == "not in")
            {
                $this->model = $this->model->whereNotIn($attribute, $value);
            }

            if ($operator == "like")
            {
                $this->model = $this->model->where($attribute, "like", $value);
            }

            if ($operator == "not like")
            {
                $this->model = $this->model->where($attribute, "not like", $value);
            }

            if ($operator == "null")
            {
                $this->model = $this->model->whereNull($attribute);
            }

            if ($operator == "not null")
            {
                $this->model = $this->model->whereNotNull($attribute);
            }
        }
    }

    protected function addPostFunction (&$result, array $functions)
    {
        if (empty($functions))
        {
            return;
        }

        foreach ($functions as $arr)
        {
            $function = array_shift($arr);
            $result   = $result->$function(...$arr);
        }
    }
}