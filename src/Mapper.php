<?php

namespace Pourbahrami\Mapper;

class Mapper
{
    private $input;
    private $map;
    private $omit;

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

    public function map(array $map, array $omit = [])
    {
        $this->map = $map;
        $this->omit = $omit;
        return $this->remap($this->input);
    }

    private function remap($value, $parents = '')
    {
        if (is_array($value)) {
            $newArr = [];
            foreach ($value as $key => $val) {
                if (is_numeric($key)) {
                    $newArr[$key] = $this->remap($val, $parents);
                } else {
                    if (in_array($key, $this->omit)) continue;
                    $fullKey = $parents ? $parents . '.' . $key : $key;
                    $newKey = isset($this->map[$fullKey]) ? $this->map[$fullKey] : $key;
                    $newArr[$newKey] = $this->remap($val, $fullKey);
                }
            }
            return $newArr;
        } else {
            return $value;
        }
    }
}
