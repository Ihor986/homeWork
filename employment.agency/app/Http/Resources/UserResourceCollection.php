<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['data' => $this->collection];
        // 'collection' => $this->collection,

        // // 'links' => ['test' => 'some value'],

        // 'meta' => [
        //     'count' => $this->count(),
        //     'current_page' => $this->currentPage(),
        //     'from' => $this->firstItem(),
        //     'last_page' => $this->lastPage(),
        //     'per_page' => $this->perPage(),
        //     'to' => $this->lastItem(),
        //     'total' => $this->total()
        // ]
    }
}
