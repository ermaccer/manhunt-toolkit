<?php
namespace App\Tests\LevelScripts;

use App\Service\Archive\Glg;
use App\Service\Archive\Mls;
use App\Service\Compiler\Compiler;
use App\Service\Compiler\FunctionMap\Manhunt2;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UsableScriptTest extends KernelTestCase
{

    public function test()
    {

        $script = "
scriptmain UsableScript;

entity buttonInsideElev(S) : et_name;

const
	cBlinkDelay = 300;

var

	lSavePointTutRemoved :  level_var boolean;
	lButtonTutRemoved :  level_var boolean;

	me : string[30];


script OnCreate;
begin
	me := GetEntityName(this);

	WriteDebug(me, ' : OnCreate');

	SetSwitchState(this, 0);

	RunScript(me, 'BlinkRed');

	AttachToEntity(this, GetEntity('real_asylum_elev'));

	lButtonTutRemoved := false;
end;


script OnUseByPlayer;

VAR
	pos : vec3d;

begin
	WriteDebug(me, ' : OnUseByPlayer');

	SetSwitchState(this, 1);

	RunScript(me, 'BlinkGreen');

	EnableUseable(this, FALSE);

	{Stop sneaky players from escaping}
	EntityIgnoreCollisions(GetEntity('elev_door_block'), FALSE);
	EntityIgnoreCollisions(this, TRUE);
{	RunScript('triggerChairDestroyer', 'DestroyChairs');}

{	ShowEntity(GetEntity('BoxBlocker'));}

  { turn jumping off in elevator, will be turned on in elevator script again when elevator doors are open again }
	SetPlayerJumpFlag(false);



	ClearLevelGoal('GOAL6');
	SetLevelGoal('GOAL10');

	Runscript('real_asylum_elev', 'Start');

	{RunScript('buttonInsideElev(S)', 'RemoveCrap');}

	SetVector(pos, -17.898, 7.04834, 12.7896);
	{MoveEntity(GetEntity('leo(hunter)'), pos,1);
	ShowEntity(GetEntity('leo(hunter)'));}
	sleep(1500);



	{CutSceneStart;}
		{SKIP SCRIPT}

		{AICutSceneEntityEnable('leo(hunter)', true);
		LockPed('leo(hunter)', false);
		AISetEntityIdleOverRide('leo(hunter)', false, false);

		AIAddGoalForSubpack('leo(leader)', 'leopack', 'gRunTwo');

		CutSceneRegisterSkipScript(this, 'SkipMe');}



		{sleep(150);}

		{SetVector(pos, -17.1376, 8.62591, 7.61494);
		SetCameraPosition(pos);
		SetVector(pos, 0.17959, -0.253758, 0.95045);
		SetCameraView(pos);
		SetZoomLerp(0.614214, 0.614214, 0.1);



		sleep(1000);
		SetVector(pos, -17.1376, 8.62591, 7.61494);
		PlayScriptAudioStreamFromPosAuto('LEO18', 100, pos ,10);
    while not IsScriptAudioStreamCompleted do sleep(10);}
		{PlayDirectorSpeechPlaceholder('WAIT1_A');}
		{ === End Cutscene Camera Animation Block (cameraFPLeo) === }

		{sleep(4000);

	CutSceneEnd(false);}

	{ [gupi] turn off tutorial texts }
	{if not lSavePointTutRemoved then
	begin
		lSavePointTutRemoved := true;
		RemoveScript('A01_Escape_Asylum', 'DisplaySavePointTutorials');
	end;
	if not lButtonTutRemoved then
	begin
		lButtonTutRemoved := true;
		RemoveScript('A01_Escape_Asylum', 'DisplayButtonTutorials');
	end;}

	sleep(1000);

	while IsGameTextDisplaying do
		Sleep(100);

	DisplayGameText('PAUSE');


	sleep(1000);
{	PlayDirectorSpeechPlaceholder('MTP1_A');}
	lButtonTutRemoved := TRUE;

end;

script RemoveCrap;
begin


{---------------------------------------
 Sector 4
 ---------------------------------------}

        DestroyEntity(GetEntity('CJ_Radiator_old07'));
        DestroyEntity(GetEntity('CJ_Radiator_old08'));
        DestroyEntity(GetEntity('CJ_Radiator_old09'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright07'));
        DestroyEntity(GetEntity('DE_MattressDown07'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright08'));
        DestroyEntity(GetEntity('DE_MattressDown08'));
        DestroyEntity(GetEntity('Wash_Bowl_Old08'));
        DestroyEntity(GetEntity('Wash_Bowl_Old09'));
        DestroyEntity(GetEntity('Wash_Bowl_Old10'));
        DestroyEntity(GetEntity('DirtyOldToilet13'));
        DestroyEntity(GetEntity('DirtyOldToilet14'));
        DestroyEntity(GetEntity('DirtyOldToilet15'));
        DestroyEntity(GetEntity('Clipboard_Medical04'));
        DestroyEntity(GetEntity('DE_MattressDown10'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright10'));
        DestroyEntity(GetEntity('SA_Rubbish_D'));
        DestroyEntity(GetEntity('SA_Rubbish_F'));
        DestroyEntity(GetEntity('broken_chair03'));
        DestroyEntity(GetEntity('CJ_PLASTIC_CHAIR25'));
        DestroyEntity(GetEntity('CJ_GREENHSHELVES09'));
        DestroyEntity(GetEntity('Clipboard_Medical08'));
        DestroyEntity(GetEntity('SA_Rubbish_I11'));


{---------------------------------------
 Sector 5
 ---------------------------------------}

        DestroyEntity(GetEntity('CJ_MINICAMB_(L)'));
        DestroyEntity(GetEntity('Wash_Bowl_Old'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright02'));
        DestroyEntity(GetEntity('DE_MattressDown02'));
        DestroyEntity(GetEntity('Gen_Tannoy_(F)04'));
        DestroyEntity(GetEntity('CJ_PLASTIC_CHAIR21'));
        DestroyEntity(GetEntity('SA_Rubbish_B01'));
        DestroyEntity(GetEntity('broken_chair'));
        DestroyEntity(GetEntity('coffee_table01_food07'));
        DestroyEntity(GetEntity('SA_Rubbish_I12'));
        DestroyEntity(GetEntity('DirtyOldToilet3'));

{---------------------------------------
 Sector 6
 ---------------------------------------}

        DestroyEntity(GetEntity('Syringe_(CT)04'));;
        DestroyEntity(GetEntity('CJ_Radiator_old01'));
        DestroyEntity(GetEntity('CJ_Radiator_old02'));
        DestroyEntity(GetEntity('Wash_Bowl_Old01'));
        DestroyEntity(GetEntity('Wash_Bowl_Old02'));
        DestroyEntity(GetEntity('DirtyOldToilet2'));
        DestroyEntity(GetEntity('DirtyOldToilet04'));
        DestroyEntity(GetEntity('Clipboard_Medical01'));
        DestroyEntity(GetEntity('CJ_PLASTIC_CHAIR13'));
        DestroyEntity(GetEntity('Gen_Tannoy_(F)02'));
        DestroyEntity(GetEntity('Clipboard_Medical06'));
        DestroyEntity(GetEntity('SA_Rubbish_I01'));
        DestroyEntity(GetEntity('broken_chair01'));
        DestroyEntity(GetEntity('SA_Rubbish_D05'));
        DestroyEntity(GetEntity('coffee_table01_food09'));
        DestroyEntity(GetEntity('SA_Rubbish_I08'));
        DestroyEntity(GetEntity('SA_Rubbish_I09'));
        DestroyEntity(GetEntity('broken_chair06'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright14'));
        DestroyEntity(GetEntity('DE_MattressDown15'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright15'));
        DestroyEntity(GetEntity('DE_MattressBent06'));


{---------------------------------------
 Sector 7
 ---------------------------------------}


        DestroyEntity(GetEntity('CJ_Radiator_old03'));
        DestroyEntity(GetEntity('Wash_Bowl_Old03'));
        DestroyEntity(GetEntity('DE_MattressDown01'));
        DestroyEntity(GetEntity('CJ_bunk_bed_upright'));
        DestroyEntity(GetEntity('DirtyOldToilet05'));
        DestroyEntity(GetEntity('SA_Rubbish_I10'));
        DestroyEntity(GetEntity('SA_Rubbish_B09'));


{---------------------------------------
 Sector 8
 ---------------------------------------}



{---------------------------------------
 Sector 9
 ---------------------------------------}


        DestroyEntity(GetEntity('CJ_WSHELF07'));
        DestroyEntity(GetEntity('CJ_Radiator_old04'));
        DestroyEntity(GetEntity('CJ_Radiator_old06'));
        DestroyEntity(GetEntity('CJ_PLASTIC_CHAIR15'));
        DestroyEntity(GetEntity('Gen_Tannoy_(F)03'));
        DestroyEntity(GetEntity('CJ_GREENHSHELVES05'));
        DestroyEntity(GetEntity('painkiller_cabinet_ng'));
        DestroyEntity(GetEntity('broken_table01'));
        DestroyEntity(GetEntity('broken_chair02'));
        DestroyEntity(GetEntity('broken_tv'));
        DestroyEntity(GetEntity('coffee_table01_food05'));
        DestroyEntity(GetEntity('SA_Rubbish_B03'));
        DestroyEntity(GetEntity('SA_Rubbish_I03'));
        DestroyEntity(GetEntity('paper_bin'));
        DestroyEntity(GetEntity('SA_Rubbish_B08'));
        DestroyEntity(GetEntity('DirtLockerC05'));
        DestroyEntity(GetEntity('SA_Rubbish_D07'));
        DestroyEntity(GetEntity('paper_bin04'));


{---------------------------------------
 Sector 10
 ---------------------------------------}

        DestroyEntity(GetEntity('CJ_ELCTRICBOX2'));
        DestroyEntity(GetEntity('CJ_ELCTRICBOX06'));
        DestroyEntity(GetEntity('SA_Rubbish_D01'));
        DestroyEntity(GetEntity('coffee_table01_food06'));
        DestroyEntity(GetEntity('paper_bin01'));
        DestroyEntity(GetEntity('broken_chair07'));
        DestroyEntity(GetEntity('SA_Rubbish_D06'));
        DestroyEntity(GetEntity('Gen_Tannoy_(F)06'));
        DestroyEntity(GetEntity('CJ_ELCTRICBOX07'));
end;

script BlinkRed;
begin
	WriteDebug(me, ' : BlinkRed');

	KillScript(me, 'BlinkGreen');

	while TRUE do
	begin
    	SetCurrentLOD(this, 1);
    	sleep(cBlinkDelay);
    	SetCurrentLOD(this, 0);
    	sleep(cBlinkDelay);
	end;
end;


script BlinkGreen;
begin
	WriteDebug(me, ' : BlinkGreen');

	KillScript(me, 'BlinkRed');

	while TRUE do
	begin
    	SetCurrentLOD(this, 2);
    	sleep(cBlinkDelay);
    	SetCurrentLOD(this, 0);
    	sleep(cBlinkDelay);
	end;
end;


script StopWorking;
VAR
	flickerCount : integer;
begin
	KillScript(me, 'BlinkRed');
	KillScript(me, 'BlinkGreen');
	Sleep(50);
   	SetCurrentLOD(this, 0);

  flickerCount := 0;

  for flickerCount := 1 to 10 do
  begin
  	SetCurrentLOD(GetEntity('real_asylum_elev'), 0);
  	SetCurrentLOD(GetEntity('Upt_Elevator_DoorIR_(SD)'), 0);
  	SetCurrentLOD(GetEntity('Upt_Elevator_DoorIL_(SD)'), 0);
  	Sleep(RandNum(100) + 30);
  	SetCurrentLOD(GetEntity('real_asylum_elev'), 1);
  	SetCurrentLOD(GetEntity('Upt_Elevator_DoorIR_(SD)'), 1);
  	SetCurrentLOD(GetEntity('Upt_Elevator_DoorIL_(SD)'), 1);
  	Sleep(RandNum(100) + 30);
  end;

  {SetCurrentLOD(GetEntity('Upt_Elevator_DoorIR_(SD)'), 2);
  HideEntity(GetEntity('A01_dead_blood'));}

end;

script SkipMe;
begin
end;

end.

        ";

        $expected = [

            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block

            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '86000000', //getentityname Call
            '21000000', //Prepare string read (header)
            '04000000', //Prepare string read (header)
            '04000000', //Prepare string read (header)
            'fc070000', //Offset in byte

            '12000000', //parameter (read string array? assign?)
            '03000000', //parameter (read string array? assign?)
            '1e000000', //value 30
            '10000000', //parameter (read string array? assign?)
            '04000000', //parameter (read string array? assign?)
            '10000000', //unknown
            '03000000', //unknown
            '48000000', //unknown
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '04000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0c000000', //value 12
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '74000000', //writedebugflush Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '95000000', //setswitchstate Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '14000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '09000000', //value 9
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e4000000', //runscript Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '20000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '93000000', //AttachToEntity Call
            '12000000', //parameter (access level_var)
            '01000000', //parameter (access level_var)
            '00000000', //value 0
            '1a000000', //parameter (access level_var)
            '01000000', //parameter (access level_var)
            '64170000', //unknown
            '04000000', //unknown
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block
            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block
            '34000000', //reserve bytes
            '09000000', //reserve bytes
            '0c000000', //Offset in byte
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '34000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '74000000', //writedebugflush Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '01000000', //value 1
            '10000000', //nested call return result
            '01000000', //nested call return result
            '95000000', //setswitchstate Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '48000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0b000000', //value 11
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e4000000', //runscript Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            'e5020000', //EnableUseable Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '54000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a2020000', //EntityIgnoreCollisions Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '01000000', //value 1
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a2020000', //EntityIgnoreCollisions Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '24030000', //SetPlayerJumpFlag Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '68000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '06000000', //value 6
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '42020000', //clearlevelgoal Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '70000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '07000000', //value 7
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '41020000', //setlevelgoal Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '78000000', //GetEntityPosition Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '8c000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '06000000', //value 6
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e4000000', //runscript Call
            '22000000', //Prepare string read (3)
            '04000000', //Prepare string read (3)
            '01000000', //Prepare string read (3)
            '0c000000', //Offset in byte
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '1b2f8f41', //value 1099902747
            '10000000', //nested call return result
            '01000000', //nested call return result
            '4f000000', //turn prev number into negative
            '32000000', //turn prev number into negative
            '09000000', //turn prev number into negative
            '04000000', //turn prev number into negative
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '008ce140', //value 1088523264
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '34a24c41', //value 1095541300
            '10000000', //nested call return result
            '01000000', //nested call return result
            '84010000', //setvector Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            'dc050000', //value 1500
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            'e8030000', //value 1000
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '07010000', //IsGameTextDisplaying Call
            '24000000', //statement (end sequence)
            '01000000', //statement (end sequence)
            '00000000', //statement (end sequence)
            '3f000000', //statement (init start offset)
            '30050000', //Offset (line number 332)
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '64000000', //value 100
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '3c000000', //statement (init statement start offset)
            'f8040000', //Offset (line number 318)
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '94000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '06000000', //value 6
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '04010000', //displaygametext Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            'e8030000', //value 1000
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '12000000', //parameter (access level_var)
            '01000000', //parameter (access level_var)
            '01000000', //value 1
            '1a000000', //parameter (access level_var)
            '01000000', //parameter (access level_var)
            '64170000', //unknown
            '04000000', //unknown
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block
            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '9c000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'b0000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'c4000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd8000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'f0000000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '04010000', //displaygametext Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '1c010000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '30010000', //IsNamedItemInInventory Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '44010000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '58010000', //aidefinegoalhuntenemy Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '6c010000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '80010000', //AISetHunterIdleActionMinMax Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '94010000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'a8010000', //aisethunteronradar Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '14000000', //value 20
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'c0010000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd4010000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'ec010000', //AIReturnSubpackEntityName Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0d000000', //value 13
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc010000', //AIDefineGoalGuardLookAtEntity Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0d000000', //value 13
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '0c020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '1c020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '13000000', //value 19
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '30020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '13000000', //value 19
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '44020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '14000000', //value 20
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '5c020000', //PlayAudioOneShotFromEntity Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '6c020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '80020000', //SetPlayerHeading Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0e000000', //value 14
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '90020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'a8020000', //setmaxnumberofrats Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'bc020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd0020000', //SetTimer Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '13000000', //value 19
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'e4020000', //IsPlayerWallSquashed Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'f4020000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0d000000', //value 13
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '04030000', //ThisLevelBeenCompletedAlready Call
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '1c030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '2c030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '40030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '50030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '64030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '78030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '8c030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'a0030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'b4030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'c8030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '14000000', //value 20
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'e0030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '13000000', //value 19
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'f4030000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '08040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '14000000', //value 20
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '20040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '30040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '40040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '50040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '68040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '78040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '88040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '98040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'b0040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'c4040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'dc040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'f0040000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '04050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '18050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '2c050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '14000000', //value 20
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '44050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '58050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '68050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '78050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0c000000', //value 12
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '88050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '9c050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '12000000', //value 18
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'b0050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '13000000', //value 19
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'c4050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd8050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '13000000', //value 19
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'ec050000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '04060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '14060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '24060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0a000000', //value 10
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '30060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '48060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '58060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '68060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0a000000', //value 10
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '74060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '84060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0e000000', //value 14
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '94060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'a4060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0c000000', //value 12
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'b4060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'c4060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd8060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'e8060000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '16000000', //value 22
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '00070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0c000000', //value 12
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '10070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '20070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0f000000', //value 15
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '30070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '44070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '10000000', //value 16
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            'a0020000', //DestroyEntity Call
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block
            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '58070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0c000000', //value 12
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '74000000', //writedebugflush Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '68070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0b000000', //value 11
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e5000000', //killscript Call
            '12000000', //unknown
            '01000000', //unknown
            '01000000', //unknown
            '24000000', //statement (end sequence)
            '01000000', //statement (end sequence)
            '00000000', //statement (end sequence)
            '3f000000', //statement (init start offset)
            '7c1c0000', //Offset (line number 1823)
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '01000000', //value 1
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '2c010000', //value 300
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '2c010000', //value 300
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '3c000000', //statement (init statement start offset)
            'cc1b0000', //Offset (line number 1779)
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block
            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '74070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0e000000', //value 14
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '73000000', //writedebug Call
            '74000000', //writedebugflush Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '84070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '09000000', //value 9
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e5000000', //killscript Call
            '12000000', //unknown
            '01000000', //unknown
            '01000000', //unknown
            '24000000', //statement (end sequence)
            '01000000', //statement (end sequence)
            '00000000', //statement (end sequence)
            '3f000000', //statement (init start offset)
            '1c1e0000', //Offset (line number 1927)
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '02000000', //value 2
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '2c010000', //value 300
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '2c010000', //value 300
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '3c000000', //statement (init statement start offset)
            '6c1d0000', //Offset (line number 1883)
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block
            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block
            '34000000', //reserve bytes
            '09000000', //reserve bytes
            '04000000', //Offset in byte
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '90070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '09000000', //value 9
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e5000000', //killscript Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'fc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '1e000000', //value 30
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            '9c070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '0b000000', //value 11
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            'e5000000', //killscript Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '32000000', //value 50
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '49000000', //value 73
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //unknown
            '01000000', //unknown
            '00000000', //unknown
            '15000000', //unknown
            '04000000', //unknown
            '04000000', //unknown
            '01000000', //unknown
            '12000000', //unknown
            '01000000', //unknown
            '01000000', //unknown
            '15000000', //unknown
            '04000000', //unknown
            '04000000', //unknown
            '01000000', //unknown
            '12000000', //unknown
            '01000000', //unknown
            '0a000000', //unknown
            '13000000', //unknown
            '02000000', //unknown
            '04000000', //unknown
            '04000000', //unknown
            '23000000', //unknown
            '01000000', //unknown
            '02000000', //unknown
            '41000000', //unknown
            'c41f0000', //unknown
            '3c000000', //statement (init statement start offset)
            '50220000', //Offset (line number 2196)
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'a8070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'bc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '19000000', //value 25
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd8070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '19000000', //value 25
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '00000000', //value 0
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '64000000', //value 100
            '10000000', //nested call return result
            '01000000', //nested call return result
            '69000000', //randnum Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (temp int)
            '01000000', //parameter (temp int)
            '1e000000', //value 30
            '0f000000', //parameter (temp int)
            '04000000', //parameter (temp int)
            '31000000', //unknown
            '01000000', //unknown
            '04000000', //unknown
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'a8070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '11000000', //value 17
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '01000000', //value 1
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'bc070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '19000000', //value 25
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '01000000', //value 1
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '21000000', //Prepare string read (DATA table)
            '04000000', //Prepare string read (DATA table)
            '01000000', //Prepare string read (DATA table)
            'd8070000', //Offset in byte
            '12000000', //parameter (Read String var)
            '02000000', //parameter (Read String var)
            '19000000', //value 25
            '10000000', //nested call return result
            '01000000', //nested call return result
            '10000000', //nested string return result
            '02000000', //nested string return result
            '77000000', //getentity Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '01000000', //value 1
            '10000000', //nested call return result
            '01000000', //nested call return result
            '2d010000', //setcurrentlod Call
            '12000000', //parameter (read simple type (int/float...))
            '01000000', //parameter (read simple type (int/float...))
            '64000000', //value 100
            '10000000', //nested call return result
            '01000000', //nested call return result
            '69000000', //randnum Call
            '10000000', //nested call return result
            '01000000', //nested call return result
            '12000000', //parameter (temp int)
            '01000000', //parameter (temp int)
            '1e000000', //value 30
            '0f000000', //parameter (temp int)
            '04000000', //parameter (temp int)
            '31000000', //unknown
            '01000000', //unknown
            '04000000', //unknown
            '10000000', //nested call return result
            '01000000', //nested call return result
            '6a000000', //sleep Call
            '2f000000', //unknown
            '04000000', //unknown
            '00000000', //unknown
            '3c000000', //statement (init statement start offset)
            '8c1f0000', //Offset (line number 2019)
            '30000000', //unknown
            '04000000', //unknown
            '00000000', //unknown
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block
            '10000000', //Script start block
            '0a000000', //Script start block
            '11000000', //Script start block
            '0a000000', //Script start block
            '09000000', //Script start block
            '11000000', //Script end block
            '09000000', //Script end block
            '0a000000', //Script end block
            '0f000000', //Script end block
            '0a000000', //Script end block
            '3b000000', //Script end block
            '00000000', //Script end block

        ];

//
        $compiler = new Compiler();
        $levelScriptCompiled = $compiler->parse(file_get_contents(__DIR__ . '/0#levelscript.srce'));


        $compiler = new Compiler();
        $compiled = $compiler->parse($script, $levelScriptCompiled);

        if ($compiled['CODE'] != $expected){
            foreach ($compiled['CODE'] as $index => $item) {
//                    echo ($index + 1) . '->' . $item . "\n";
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