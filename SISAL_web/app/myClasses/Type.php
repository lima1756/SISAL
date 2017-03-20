<?php
    namespace App\myClasses;
    /**
     * Undocumented class
     */
    class Type
    {
        private function __construct(){}

        public static function isMedic()
        {
            return logData::getType() == "medicos" ? true : false;
        }

        public static function isPatient()
        {
            return logData::getType() == "pacientes" ? true : false;
        }

        public static function isReceptionist()
        {
            return logData::getType() == "recepcionistas" ? true : false;
        }

        public static function isAdmin()
        {
            return logData::getType() == "administradores" ? true : false;
        }
    }
?>