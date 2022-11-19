<?php

namespace ClarkWinkelmann\SudoMode;

use Flarum\Settings\SettingsRepositoryInterface;

class SudoGate
{
    static $expires = 0;

    public static function canUseAdminFeatures(): bool
    {
        return self::$expires > time();
    }

    public static function expectedExpirationTimestamp(): int
    {
        return self::$expires;
    }

    public static function setValidSudo(int $timestamp): void
    {
        self::$expires = $timestamp + ((int)resolve(SettingsRepositoryInterface::class)->get('sudo-mode.duration') ?: 3600);
    }
}
