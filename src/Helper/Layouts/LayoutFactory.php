<?php

namespace MostafaHamed\DDD\Helper\Layouts;

class LayoutFactory{

    private function __construct(){}

    public static function create($type,$options = []){

        switch ($type) {
            case 'lte':
                return new AdminLTELayout($options);
                break;
            case 'dashboard':
                return new DashboardLayout($options);
                break;

            default:
                break;
        }
    }

}
