<?php
/*
|--------------------------------------------------------------------------
| DDD naming Convensions
|--------------------------------------------------------------------------
| 
| Define All Laravel Rules
| 
| Under-Developement !!!
*/

return [

    "datatable"=>'{{Name}}Datatable',
    
    "database"=>[
        "factory"=>'{{Name}}Factory',
        "migration_create"=>'{{@Y}}_{{@M}}_{{@D}}_{{@ms}}_create_{{Name}}_table',
        "migration_update"=>'{{@Y}}_{{@M}}_{{@D}}_{{@ms}}_update_{{Name}}_table',
        "seeder"=>'{{Name}}Seeder',
    ],
    
    "entity"=>[
        "model"=>'{{Name}}',
        "custom_attribute"=>'{{Name}}Attributes',
        "custom_relation"=>'{{Name}}Relations',
    ],

    "controller"=>[
        "name"=>'{{Name}}Controller',
        "custom_attribute"=>'{{Name}}Attributes',
        "custom_relation"=>'{{Name}}Relations',
    ],
];