<?php

namespace Requests;

/**
 * 入園日時は未来でなくてはならない
 */
class AdmissionDatetime implements Validatable
{
    public static function validate($value): bool
    {
        try{
            return (bool)new \DateTime($value);
        }catch(\Exception $e){
            return false;
        }
    }
}
