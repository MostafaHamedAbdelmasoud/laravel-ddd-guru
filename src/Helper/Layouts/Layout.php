<?php

namespace MostafaHamed\DDD\Helper\Layouts;

use MostafaHamed\DDD\Helper\Path;

abstract class Layout{

    /**
     * Define options to build the current AdminPannel
     *
     * @var array
     */
    protected $options;

    /**
     * Specify the directory name of the layout-view
     *
     * @param string $viewName
     */
    protected $viewName;

    /**
     * Define layout view-path
     *
     * @var string
     */
    protected $path;

    /**
     * Init the options attributes
     *
     * @param Array $options optional
     */
    public function __construct(Array $options = []){
        $this->options = $options;

        $this->path = Path::build(Path::package(),'src','views',$this->viewName);
    }

    /**
     * Create layout and files for the current template
     *
     * @return Bool
     */
    abstract function build() : Bool;

}
