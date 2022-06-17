<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Migration extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'domain',
        'entity',
        'append',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'entity'
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [
        'append'
    ];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $requiredUnless = [];

    /**
     * Fill all placeholders in the stub file
     *
     * @return Boll
     */
    public function service(Array $values = []):bool{

        if($values['append']){
            $values['append']="table";
            $file_action="update";
        }else{
            $file_action = $values['append'] = "create";
        }

        $class = NamespaceCreator::entity($values['domain'],$values['entity']);
        $table = with(new $class)->getTable();

        $name =Naming::class(Str::of($table)->replace('_',' ')) ;

        $attributes ="\n";

        $down = "Schema::table('$table', function (Blueprint \$table) {
            \$table->dropColumn('');
        });";

        if($values['append']=="create"){
            $attributes.="\t\t\t\$table->id();\n\t\t\t\$table->string('name');\n";

            $attributes.="\t\t\t\$table->timestamps();\n";
            $down = "Schema::dropIfExists('$table');";
        }

        $placeholders = [
            '{{FILE_ACTION}}'       =>   Str::ucfirst($file_action),
            '{{CREATE_OR_TABLE}}'   =>   $values['append'],
            '{{NAME}}'              =>   $name,
            '{{TABLE_NAME}}'        =>   $table,
            '{{TABLE_COLUMNS}}'     =>   $attributes,
            '{{DOWN}}'              =>   $down
        ];

        $fileName = Naming::migration($file_action,$table);

        $destination = Path::toDomain($values['domain'],'Database','Migrations',$fileName);

        $content = Str::of($this->getStub('migration'))
        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save(trim($destination,$fileName),trim($fileName,'.php'),'php',$content);

        return true;
    }

}
