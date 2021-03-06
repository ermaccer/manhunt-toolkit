<?php
namespace App\Service\Archive;

use App\Service\Binary;

class Inst {

    /**
     * Manhunt 2 - entity_pc.inst pack/unpack
     */

    public function unpack($data, $game){

        $binary = new Binary( $data );

        $placements = $binary->substr(0, 4);

        $sizesLength = $placements->toInt() * 4;

        //split sizes (header) from content
        $sizes = $binary->substr(4, $sizesLength);
        $sizes = $sizes->split(4);

        $content = $binary->substr($sizesLength + 4);

        //extract every record
        $records = [];
        $pos = 0;
        foreach ($sizes as $size) {
            $size = $size->toInt();
            $records[] = $this->parseRecord( $content->substr($pos, $size), $game );
            $pos += $size;
        }

        return $records;
    }

    public function pack( $records, $game ){

        $result = new Binary();

        // append record count
        $result->addBinary(pack("L", count($records)));

        $recordBin = [];
        foreach ($records as $index => $record) {
            $entry = new Binary();

            /*
             * Append GlgRecord name
             */
            $glgRecord = new Binary($record['record']);

            $entry->append( $glgRecord );
            $entry->addHex('00');
            $entry->addHex( str_repeat('70', $glgRecord->getMissedBytes() - 1 ) );

            /*
             * Append Internal name
             */
            $internalName = new Binary($record['internalName']);

            $entry->append( $internalName );
            $entry->addHex('00');
            $entry->addHex( str_repeat('70', $internalName->getMissedBytes() - 1 ) );

            /*
             * Append XYZ coordinates
             */

            if ($game == "mh2"){
                $record['position']['y'] = $record['position']['y'] * -1;
                $record['position']['z'] = $record['position']['z'] * -1;
            }

            $entry->addBinary(pack('g*' , $record['position']['x']));
            $entry->addBinary(pack('g*' , $record['position']['y']));
            $entry->addBinary(pack('g*' , $record['position']['z']));

            /*
             * Append rotation
             */
            $entry->addBinary(pack('g*' , $record['rotation']['x']));
            $entry->addBinary(pack('g*' , $record['rotation']['y']));
            $entry->addBinary(pack('g*' , $record['rotation']['z']));
            $entry->addBinary(pack('g*' , $record['rotation']['w']));

            /*
             * Append entity class
             */
            if ($record['entityClass']){

                $entityClass = new Binary($record['entityClass']);

                $entry->append( $entityClass );
                $entry->addHex('00');

                $entry->addHex( str_repeat('70', $entityClass->getMissedBytes() - 1 ) );
            }

            if ($game == "mh2"){

                /*
                 * Append parameters
                 */
                foreach ($record['parameters'] as $parameter) {

                    $entry->addHex($parameter['parameterId']);

                    $type = new Binary($parameter['type']);
                    $type->addMissedBytes('00');

                    $entry->append($type);

                    switch ($parameter['type']) {
                        case 'flo':
                            $entry->addBinary(pack("f", $parameter['value']));
                            break;
                        case 'boo':
                        case 'int':
                            $entry->addBinary( pack("L", $parameter['value']) );
                            break;
                        case 'str':

                            $value = new Binary($parameter['value']);
                            $missedToFinal4Byte = $value->getMissedBytes() - 1;

                            $entry->append($value);

                            $entry->addHex('00');
                            $entry->addHex( str_repeat('70', $missedToFinal4Byte ) );

                            break;
                    }
                }
            }else{
                $entry->addHex($record['parameters']);
            }

            $recordBin[] = $entry;
        }

        /** @var Binary[] $recordBin */

        // build size header
        foreach ($recordBin as $record) {
            $result->addBinary(pack("L", $record->length(true) / 2));
        }

        // append records
        foreach ($recordBin as $record) {
            $result->append($record);
        }

        return $result->toBinary();
    }


    public function parseRecord( Binary $record, $game ){

        /** @var Binary $remain */
        /** @var Binary $rotation */

        /**
         * Find the  Record
         */
        $glgRecord = $record->substr(0, "\x00", $remain);
        $remain = $remain->skipBytes($glgRecord->getMissedBytes());

        /**
         * Find the internal name
         */
        $internalName = $remain->substr(0, "\x00", $remain);
        $remain = $remain->skipBytes($internalName->getMissedBytes());

        /**
         * Find the position and rotation
         */
        $position = $remain->substr(0, 28, $remain);

        $x = $position->substr(0, 4, $position);
        $y = $position->substr(0, 4, $position);
        $z = $position->substr(0, 4, $rotation);

        $x = current(unpack('g*' , $x->toBinary()));
        $y = current(unpack('g*' , $y->toBinary()));
        $z = current(unpack('g*' , $z->toBinary()));


        $rotationX = $rotation->substr(0, 4, $rotation);
        $rotationY = $rotation->substr(0, 4, $rotation);
        $rotationZ = $rotation->substr(0, 4, $rotation);
        $rotationW = $rotation->substr(0, 4);

        $rotationX = current(unpack('g*' , $rotationX->toBinary()));
        $rotationY = current(unpack('g*' , $rotationY->toBinary()));
        $rotationZ = current(unpack('g*' , $rotationZ->toBinary()));
        $rotationW = current(unpack('g*' , $rotationW->toBinary()));

        /**
         * Find the entity class
         */
        $entityClass = $remain->substr(0, "\x00", $remain);
        $remain = $remain->skipBytes($entityClass->getMissedBytes());


        if ($game == "mh2"){
            /**
             * Find parameters
             */
            $params = [];
            do {

                // always 4-byte long
                $parameterId  = $remain->substr(0, 4, $remain);
                if ($remain->length()){

                    // always 4-byte long
                    $type = $remain->substr(0, 4, $remain);

                    // float, boolean, integer are always 4-byte long
                    // string need to be calculated
                    switch ($type->toString()) {
                        case 'flo':
                            $value = $remain->substr(0, 4, $remain)->toFloat();
                            break;
                        case 'boo':
                            $value = $remain->substr(0, 4, $remain)->toBoolean();
                            break;
                        case 'int':
                            $value = $remain->substr(0, 4, $remain)->toInt();
                            break;
                        case 'str':

                            $value = $remain->substr(0, "\x00", $remain);
                            $remain = $remain->skipBytes($value->getMissedBytes());
                            $value = $value->toString();
                            break;
                        default:
                            var_dump($internalName);
                            die("type unknown " . $type->toHex());
                    }

                    $params[] = [
                        'parameterId' => $parameterId->toHex(),
                        'type' => $type->toString(),
                        'value' => $value
                    ];
                }

            }while($remain->length());

        }else{
            $params = $remain->toHex();
        }

        return [
            'record' => $glgRecord->toBinary(),
            'internalName' => $internalName->toBinary(),
            'entityClass' => $entityClass->toBinary(),
            'position' => [
                'x' => $x,
                'y' => $game == 'mh2' ? $y * -1 : $y,
                'z' => $game == 'mh2' ? $z * -1 : $z,
            ],
            'rotation' => [
                'x' => $rotationX,
                'y' => $rotationY,
                'z' => $rotationZ,
                'w' => $rotationW,
            ],
            'parameters' => $params
        ];
    }

}
