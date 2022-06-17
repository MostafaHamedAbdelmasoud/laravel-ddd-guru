<?php

namespace App\Common\Components\Header;

use Illuminate\Support\Facades\File;
use Illuminate\View\Component as BladeComponent;

class Component extends BladeComponent
{
    /**
     * The alert message.
     *
     * @var string
     */
    public $menus;
    
    /**
     * Create the component instance.
     *
     * @param  string  $input
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('Component::Header.view');
    }
}