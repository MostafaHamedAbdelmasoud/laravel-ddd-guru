<?php
namespace MostafaHamed\DDD\Traits;

use Illuminate\View\View;

trait Responder{

    protected $view = null;
    protected $resource = null;
    protected $api_response = null;

    // TODO : only one variable + filter
    protected $api_data = [];
    protected $web_data = [];

    protected $collection_base_key = '';
    protected $redirect_back = false;
    protected $redirect_route = false;
    protected $appendResourceCallback = false;


    /**
     * Define View
     *
     * @param string $view
     * @return void
     */
    public function addView($view){
        $this->view = $view;
    }


    public function redirectBack(){
        $this->redirect_back = true;
    }
    public function redirectRoute($route, $args = []){
        $this->redirect_route = [
            'route'=>$route,
            'args'=>$args
        ];
    }
    /**
     * User Collection
     *
     * @param Resource $resource
     * @param String $key
     * @return void
     */
    public function useCollection($resource,$key){
        $this->resource = $resource;
        $this->collection_base_key = $key;
    }


    /**
     * Set API Response
     *
     * @param callable $resource
     * @return void
     */
    public function setApiResponse(callable $response){
        $this->api_response = $response;
    }

    /**
     * Set Data
     *
     * @param String $key
     * @param boolean $value
     * @return void
     */
    public function setData($key,$value, $type='all'){
        switch ($type) {
            case 'web':
                $this->web_data[$key]=$value;
                break;
            case 'api':
                $this->api_data[$key]=$value;
                break;
            default:
                $this->api_data[$key]=$value;
                $this->web_data[$key]=$value;
                break;
        }
    }

    /**
     * Generate Response
     *
     * @return void
     */
    public function response() {

        if(request()->expectsJson()){
            if($this->api_response){
                $response = ($this->api_response)();
            }else{

                $data = $this->api_data[$this->collection_base_key];

                if($this->appendResourceCallback){
                    $response = (new $this->resource($data,$this->appendResourceCallback));
                }else{
                    $response = (new $this->resource($data));
                }

                unset($this->api_data[$this->collection_base_key]);

                $response->additional($this->api_data);
            }

        }else{

            if($this->redirect_back){
                $response = back()->with($this->web_data);
            }else if($this->redirect_route){
                $response = redirect()->route($this->redirect_route['route'],$this->redirect_route['args'])->with($this->web_data);
            }else{
                $response =  view($this->view,$this->web_data);
            }
        }

        return $response;

    }

    public function appendResource($key, callable $callback){
        $this->appendResourceCallback = $callback;
    }
}
