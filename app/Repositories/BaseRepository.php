<?php

namespace App\Repositories;
use App\Models\Post;

abstract class BaseRepository
{
    protected $model;
    protected $limit = 5;
    // other properties

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * store default method for repository
     * @param array
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function store($request)
    {
        return  $this->model->create($request);
    }

    /**
     * store default method for repository
     * @param array
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function update($request, $id)
    {
        $record = $this->findById($id);
        return $record->update($request);
    }

    /**
     * store default method for repository
     * @param int id
     * @return void
     */
    public function destroy($id)
    {
        $record = $this->findById($id);
        return $record->delete($record);
    }
    /**
     *  Limit Number of department return by default 5
     *
     * @param  int  $limitNumber
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function limit($limit)
    {

        if ($limit > 0) {
            $this->limit = $limit;
        }

        return  $this->model::limit($this->limit)->get();
    }
}