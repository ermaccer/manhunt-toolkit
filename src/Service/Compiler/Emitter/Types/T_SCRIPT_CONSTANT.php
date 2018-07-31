<?php
namespace App\Service\Compiler\Emitter\Types;


use App\Bytecode\Helper;

class T_SCRIPT_CONSTANT {

    static public function map( $node, \Closure $getLine, \Closure $emitter, $data ){


        if ($data['calculateLineNumber']){
            $mapped = $data['const'][$node['value']];
        }else{
            $mapped = [
                'offset' => '12345678',
                'length' => 11
            ];
        }

        return [
            $getLine('21000000'),
            $getLine('04000000'),
            $getLine('01000000'),

            $getLine($mapped['offset']),

            $getLine('12000000'),
            $getLine('02000000'),

            $getLine(Helper::fromIntToHex( $mapped['length'] + 1 ))
        ];
    }

}