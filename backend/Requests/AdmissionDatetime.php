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
            return (new \DateTime('now')) <= (new \Datetime($value));
        }catch(\Exception $e){
            return false;
        }
    }
}
