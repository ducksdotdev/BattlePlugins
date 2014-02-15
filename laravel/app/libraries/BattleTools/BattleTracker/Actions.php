<?php
namespace BattleTools\BattleTracker;

class Actions {
    const KILL = 0;
    const WIN = 1;
    const TIE = 2;

    public static function getActionName($id) {
        switch ($id) {
            case self::KILL:
                return "Kill";
            case self::WIN:
                return "Win";
            case self::TIE:
                return "Tie";
        }
        throw new \Exception("Unknown group id $id");
    }

    public static function getAll() {
        $reflector = new \ReflectionClass(__CLASS__);
        return array_values($reflector->getConstants());
    }
}
