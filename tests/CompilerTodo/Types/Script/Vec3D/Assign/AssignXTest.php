<?php
namespace App\Tests\CompilerByType\Script\Vec3D\Assign;

use App\Service\Compiler\Compiler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AssignXTest extends KernelTestCase
{

    public function test()
    {


        $script = "
            scriptmain LevelScript;
            
            entity
                A01_Escape_Asylum : et_level;

            script OnCreate;
                var
                    pos : Vec3D;
                begin
                    pos.x := 21.0;
                    
                end;

            end.
        ";

        $expected = [
            // script start
            '10000000',
            '0a000000',
            '11000000',
            '0a000000',
            '09000000',

            '34000000',
            '09000000',
            '0c000000',


            '22000000', //unknown
            '04000000', //unknown
            '01000000', //unknown
            '0c000000', //unknown

            '10000000', //nested call return result
            '01000000', //nested call return result

            '10000000', //nested call return result
            '01000000', //nested call return result



            '12000000', //parameter (function return (bool?))
            '01000000', //parameter (function return (bool?))
            '0000a841', //value 1101529088

            '0f000000', //parameter (function r#eturn (bool?))
            '02000000', //parameter (function return (bool?))
            '17000000', //unknown
            '04000000', //unknown
            '02000000', //unknown
            '01000000', //unknown


            // script end
            '11000000',
            '09000000',
            '0a000000',
            '0f000000',
            '0a000000',
            '3b000000',
            '00000000'
        ];

        $compiler = new Compiler();
        $compiled = $compiler->parse($script);

        if ($compiled['CODE'] != $expected){
            foreach ($compiled['CODE'] as $index => $item) {
                if ($expected[$index] == $item){
                    echo ($index + 1) . '->' . $item . "\n";
                }else{
                    echo "MISSMATCH need " . $expected[$index] . " got " . $compiled['CODE'][$index] . "\n";
                }
            }
            exit;
        }

        $this->assertEquals($compiled['CODE'], $expected, 'The bytecode is not correct');
    }

}