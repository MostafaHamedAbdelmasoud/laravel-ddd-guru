<?php

namespace App\Infrastructure\Http\AbstractResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    /**
     * Store Callback Method
     *
     * @var null|Closure
     */
    private $callback = null;
    
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $callback = null)
    {
        $this->resource = $resource;
        if(is_callable($callback)){
            $this->callback = $callback;
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request,Closure $callback = null)
    {
        $additioanl = [];
        
        // Called Collection
        if($callback){
            $this->callback = $callback;
        }

        // Called Resource
        if($this->callback){
            $additioanl = ($this->callback)($this);
        }
        
        return array_merge($this->data($request),$additioanl);
    }
    
    /**
     * Return Data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    abstract function data(Request $request):array;
}
