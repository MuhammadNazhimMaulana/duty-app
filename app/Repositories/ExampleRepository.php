<?php

namespace App\Repositories;

use App\Interfaces\ExampleInterface;
use App\Traits\{ResponseBuilder};
use Exception;

class ExampleRepository implements ExampleInterface
{
    use ResponseBuilder;

    public function index()
    {
        try {
            // \Log::info(request()->header());
            return $this->success();
        } catch (Exception $e) {
            $this->report($e);

            return $this->error(400, null, 'Whoops, looks like something went wrong #index');
        }
    }

    public function show(int $id)
    {
        try {
            $data = [
                'id' => $id
            ];

            return $this->success($data);
        } catch (Exception $e) {
            $this->report($e);

            return $this->error(400, null, 'Whoops, looks like something went wrong #show');
        }
    }

    public function store()
    {
        try {
            return $this->success();
        } catch (Exception $e) {
            $this->report($e);

            return $this->error(400, null, 'Whoops, looks like something went wrong #store');
        }
    }

    public function update(int $id)
    {
        try {
            $data = [
                'id' => $id
            ];

            return $this->success($data);
        } catch (Exception $e) {
            $this->report($e);

            return $this->error(400, null, 'Whoops, looks like something went wrong #update');
        }
    }

    public function delete(int $id)
    {
        try {
            $data = [
                'id' => $id
            ];

            return $this->success($data);
        } catch (Exception $e) {
            $this->report($e);

            return $this->error(400, null, 'Whoops, looks like something went wrong #delete');
        }
    }
}
