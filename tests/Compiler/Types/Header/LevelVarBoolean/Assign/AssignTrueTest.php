<?php
namespace App\Tests\CompilerByType\Header\LevelVarBoolean\Assign;

use App\Service\Archive\Glg;
use App\Service\Archive\Mls;
use App\Service\Compiler\Compiler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AssignTrueTest extends KernelTestCase
{
//
    public function test() {

        $script = "
            scriptmain LevelScript;

            var
                stealthOneLooper : level_var boolean;

            script OnCreate;

                begin
                    if stealthOneLooper = TRUE then
                    begin
                        stealthOneLooper := TRUE;
                    end;
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

            '1b000000', //unknown
            'b0170000', //LevelVar stealthOneLooper
            '04000000', //unknown
            '01000000', //unknown
            '10000000', //If statement
            '01000000', //If statement

            '12000000', //parameter (temp)
            '01000000', //parameter (temp)
            '01000000', //Bool true / int 1
            '0f000000', //parameter (temp)
            '04000000', //parameter (temp)
            '23000000', //If statement
            '04000000', //If statement
            '01000000', //If statement

            '12000000', //If statement
            '01000000', //If statement
            '01000000', //If statement
            '3f000000', //equal

            '6c000000', //If statement( current start offset)
            '33000000', //If statement
            '01000000', //If statement
            '01000000', //If statement
            '24000000', //If statement
            '01000000', //If statement
            '00000000', //If statement


            '3f000000', //store value
            '9c000000', //end offset
            '12000000', //parameter (access level_var)
            '01000000', //parameter (access level_var)
            '01000000', //Bool true / int 1
            '1a000000', //parameter (access level_var)
            '01000000', //parameter (access level_var)
            '00000000', //unknown
            '04000000', //


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
        list($sectionCode, $sectionDATA) = $compiler->parse($script);

        if ($sectionCode != $expected){
            foreach ($sectionCode as $index => $item) {
                if ($expected[$index] == $item){
                    echo ($index + 1) . '->' . $item . "\n";
                }else{
                    echo "MISSMATCH need " . $expected[$index] . " got " . $sectionCode[$index] . "\n";
                }
            }
            exit;
        }

        $this->assertEquals($sectionCode, $expected, 'The bytecode is not correct');
    }


}