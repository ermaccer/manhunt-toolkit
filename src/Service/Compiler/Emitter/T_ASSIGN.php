<?php
namespace App\Service\Compiler\Emitter;

use App\Service\Compiler\Evaluate;
use App\Service\Compiler\Token;

class T_ASSIGN {


    static public function map( $node, \Closure $getLine, \Closure $emitter, $data ){

        $code = [];

//        $mapped = Evaluate::getVariableMap($node['value'], $code, $data, $getLine, $emitter);
//
        if (!isset($data['variables'][$node['value']])){
            throw new \Exception(sprintf('T_ASSIGN: unable to detect variable: %s', $node['value']));
        }
//
        $mapped = $data['variables'][$node['value']];
//var_dump($mapped);
//exit;
        // something like val := val + 1
        if (count($node['body']) == 3) {
            $resultCode = Evaluate::handleSimpleMath($node['body'], $getLine, $emitter, $data);
            foreach ($resultCode as $line) {
                $code[] = $line;
            }

            switch ($mapped['section']){

                case 'header':

                    switch ($mapped['type']){
                        case 'level_var integer':
                            Evaluate::assignToLevelVar($mapped['offset'], $code, $getLine);
                            break;

                        case 'integer':

                            Evaluate::assignToHeaderInteger($mapped['offset'], $code, $getLine);
                            break;
                        default:
                            throw new \Exception(sprintf("Header assignment for %s is not implemented", $mapped['type']));
                    }

                    break;

                case 'script':
                    switch ($mapped['type']){
                        case 'integer':
//                            $code[] = $getLine('11000000');
//                            $code[] = $getLine('01000000');
//                            $code[] = $getLine('04000000');

                            Evaluate::assignToScriptInteger($mapped['offset'], $code, $getLine);
                            break;
                        default:
                            throw new \Exception(sprintf("Script assignment for %s is not implemented", $mapped['type']));
                    }

                    break;

                default:
                    throw new \Exception(sprintf("T_FUNCTION: section unknown %s", $mapped['section']));

            }

        }else{

            // me : string[30]
            if ($mapped['type'] == "stringArray") {

                if (
                    count($node['body']) == 1 &&
                    $node['body'][0]['type'] == Token::T_FUNCTION
                ) {

                    //evaluate the function call
                    $resultCode = $emitter($node['body'][0]);
                    foreach ($resultCode as $line) {
                        $code[] = $line;
                    }

                    Evaluate::assignToUnknownStringArray($mapped, $code, $getLine);

                    return $code;

                } else {
                    throw new \Exception(sprintf('T_ASSIGN: Unknown type for string array assignment: %s  '), $node['body'][0]['type']);
                }

                //animLength := GetAnimationLength('ASY_NURSE_ATTACK4A');
            }else if (
                $mapped['section'] == "script" &&
                strtolower($mapped['type']) == "vec3d"
            ){


                //evaluate the function call
                $resultCode = $emitter($node['body'][0]);
                foreach ($resultCode as $line) {
                    $code[] = $line;
                }

                Evaluate::assignToScriptVec3d($mapped['offset'], $code, $getLine);


            }else if ($mapped['type'] == "integer"){
                if (
                    count($node['body']) == 1 &&
                    $node['body'][0]['type'] == Token::T_FUNCTION
                ) {

                    //evaluate the function call
                    $resultCode = $emitter($node['body'][0]);
                    foreach ($resultCode as $line) {
                        $code[] = $line;
                    }

                    if ($mapped['section'] == "script") {
                        Evaluate::assignToScriptInteger($mapped['offset'], $code, $getLine);
                    }else if ($mapped['section'] == "header" && $mapped['type'] == "integer") {

                        Evaluate::assignToUnknownInteger($mapped['offset'], $code, $getLine);
                    }else{
                        // todo: checken was das hier genau war
                        var_dump($node, $mapped);
                        exit;
                    }

                } else {
                    throw new \Exception(sprintf('T_ASSIGN: Unknown type for integer assignment: %s  '), $node['body'][0]['type']);
                }



                //alreadyDone := FALSE;
            }else if ($mapped['type'] == "boolean"){

                if (
                    count($node['body']) == 1
                ) {
                    Evaluate::initializeParameterInteger($code, $getLine);

                    //evaluate the boolean
                    $resultCode = $emitter($node['body'][0]);
                    foreach ($resultCode as $line) {
                        $code[] = $line;
                    }

                    if ($mapped['section'] == "script") {
                        Evaluate::assignToScriptInteger($mapped['offset'], $code, $getLine);
                    }else{

                        // todo: checken was das hier genau war
                        Evaluate::assignToUnknownInteger($mapped['offset'], $code, $getLine);
                    }

                } else {
                    throw new \Exception(sprintf('T_ASSIGN: Unknown type for boolean assignment: %s  '), $node['body'][0]['type']);
                }

                //stealthTwoHeard := TRUE;
            }else if ($mapped['type'] == "level_var tLevelState"){

                if (isset($data['types'][$node['value']])){

                    $variableType = $data['types'][$node['value']];
                    $type = $variableType[$node['body'][0]['value']];

                    Evaluate::initializeParameterInteger($code, $getLine);

                    $code[] = $getLine($type['offset']);

                    Evaluate::assignToLevelVar($mapped['offset'], $code, $getLine);
                }else{
                    throw new \Exception(sprintf('T_ASSIGN: level_var tLevelState type not found: %s  '), $node['value']);

                }

            }else if (
                $mapped['section'] == "header" &&
                $mapped['type'] == "stringArray"
            ){

                Evaluate::assignToHeaderStringArray($mapped['offset'], $code, $getLine);

                //stealthTwoHeard := TRUE;
            }else if (
                $mapped['type'] == "level_var boolean" ||
                $mapped['type'] == "level_var integer"
            ){

                // case 1: var := true
                if (
                    count($node['body']) == 1 &&
                    (
                        $node['body'][0]['type'] == Token::T_INT ||
                        $node['body'][0]['type'] == Token::T_FALSE ||
                        $node['body'][0]['type'] == Token::T_TRUE
                    )
                ) {

                    Evaluate::initializeParameterInteger($code, $getLine);

                    //evaluate the integer
                    $resultCode = $emitter($node['body'][0]);
                    foreach ($resultCode as $line) {
                        $code[] = $line;
                    }

                    Evaluate::assignToLevelVar($mapped['offset'],  $code, $getLine);

                } else {
                    throw new \Exception(sprintf('T_ASSIGN: Unknown type for level_var boolean assignment: %s  '), $node['body'][0]['type']);
                }

            }else{
                var_dump($mapped);
                throw new \Exception(sprintf('T_ASSIGN: Type %s not implemented  ', $mapped['type']));
            }
        }

        return $code;

    }

}