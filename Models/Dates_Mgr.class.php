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
        $dayMonthYearHourMinutesSeconds = date('d/m/Y h:m', strtotime($paramDate));
        return $dayMonthYearHourMinutesSeconds;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
//  Retourne la date donnée en paramètre au format : "jj/mm/yyyy".
    public static function dateFormatDayMonthYear(String $paramDate) {
        $dayMonthYear = date('d/m/Y', strtotime($paramDate));
        return $dayMonthYear;
    }
//  °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°
    public static function addIntervalToDate(){

    }
}
?>