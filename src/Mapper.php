<?php

namespace Pourbahrami\Mapper;

class Mapper
{
    private $input;

    function __construct(array $input)
    {
        $this->input = $input;
    }

    static public function createFromJson($json): Mapper
    {
        return new Mapper(json_decode($json, true));
    }

    static public function createFromXml($xml): Mapper
    {
        return new Mapper(json_decode(json_encode(simplexml_load_string($xml)), true));
    }

    public function map(array $map)
    {
        return $this->remap($this->input, $map);
    }

    private function remap($value, array $map, $parents = '')
    {
        if (is_array($value)) {
            $newArr = [];
            foreach ($value as $key => $val) {
                if (!is_numeric($key)) {
                    $fullKey = $parents ? $parents . '.' . $key : $key;
                    $newKey = isset($map[$fullKey]) ? $map[$fullKey] : $key;
                    $newArr[$newKey] = $this->remap($val, $map, $fullKey);
                } else {
                    $newArr[$key] = $this->remap($val, $map, $parents);
                }
            }
            return $newArr;
        } else {
            return $value;
        }
    }
}
