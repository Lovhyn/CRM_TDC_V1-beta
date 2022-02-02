<?php
require_once("../Models/_BddConnexion.class.php");
class Dates_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Permet d'obtenir la valeur UNIX du moment présent en chaîne de caractère.
    public static function nowToUnixString() {
        return (string) time();
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Retourne la date donnée en paramètre au format unix en chaîne de caractère.
    public static function paramToUnixString(String $paramDate) {
        return (string) strtotime($paramDate);
}   
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Retourne la date donnée en paramètre au format : "jj/mm/yyyy hh:mm".
    public static function dateFormatDayMonthYearHourMinutesSeconds(String $paramDate) {
        if (is_null($paramDate) OR (empty($paramDate)) OR ($paramDate === '')) {
            $dayMonthYearHourMinutesSeconds = '';
        } else {
            $paramDate = (int) $paramDate;
            $dayMonthYearHourMinutesSeconds = date('d/m/Y \ à \ H:i', $paramDate);
        } 
        return $dayMonthYearHourMinutesSeconds;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Retourne la date donnée en paramètre au format : "jj/mm/yyyy".
    public static function dateFormatDayMonthYear($paramDate) {
        if (is_null($paramDate) OR (empty($paramDate)) OR ($paramDate === '')) {
            $dayMonthYear = '';
        } else {
            $paramDate = (int) $paramDate;
            $dayMonthYear = date('d/m/Y', $paramDate);
        }
        return $dayMonthYear;
    }
}
?>