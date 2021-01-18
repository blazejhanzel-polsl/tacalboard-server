<?php
namespace TasksList {
    use MyCLabs\Enum\Enum;

    class Predefinition extends Enum {
        private const ONLY_PREDEFINED = 0;
        private const ONLY_USER_DEFINED = 1;
        private const ALL = 2;

        public static function ONLY_PREDEFINED(): Predefinition {
            return new Predefinition(self::ONLY_PREDEFINED);
        }
        public static function ONLY_USER_DEFINED(): Predefinition {
            return new Predefinition(self::ONLY_USER_DEFINED);
        }

        public static function ALL(): Predefinition {
            return new Predefinition(self::ALL);
        }
    }
}
