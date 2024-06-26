<?php

namespace Advvm\Library;

use ReflectionClass;

final class Roles
{
    public const NEEDS_APPROVAL = -1;
    public const DEFAULT_USER = 0;
    public const ADMINISTRATOR = 1;

    public static function roleExists(int $roleCode): bool
    {
        $constants = (new ReflectionClass(Roles::class))->getConstants();
  
        if (in_array($roleCode, $constants)) {
            return true;
        }

        return false;
    }
}
