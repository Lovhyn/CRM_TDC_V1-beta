<?php
require_once("../Models/_BddConnexion.class.php");
class Dates_Mgr {
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Permet d'obtenir la valeur UNIX du moment présent en chaîne de caractère 
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
        $paramDate = (int) $paramDate;
        $dayMonthYearHourMinutesSeconds = gmdate('d/m/Y h:m', $paramDate);
        return $dayMonthYearHourMinutesSeconds;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Retourne la date donnée en paramètre au format : "jj/mm/yyyy".
    public static function dateFormatDayMonthYear($paramDate) {
        if (is_null($paramDate)) {
            $dayMonthYear = '';
        } else {
            $paramDate = (int) $paramDate;
            $dayMonthYear = gmdate('d/m/Y', $paramDate);
        }
        return $dayMonthYear;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function addIntervalToDate(){

    }
}
?>