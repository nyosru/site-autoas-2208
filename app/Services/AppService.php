<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Token;

class AppService
{
    public const S_GOOGLE_TITLE = 'Google Play';
    public const S_HUAWEI_TITLE = 'Huawei App Gallery';

    public const S_GOOGLE = 1;
    public const S_HUAWEI = 2;
    const NONE = 'none';
    const LIVE = 'live';
    const BAN = 'ban';

    public function getStores(): array
    {
        return [
            self::S_GOOGLE => self::S_GOOGLE_TITLE,
            self::S_HUAWEI => self::S_HUAWEI_TITLE
        ];
    }

    /**
     * none -> live можно
     * none -> ban нельзя
     * live -> none нельзя
     * live -> ban можно
     * ban -> none нельзя
     * ban -> live можно
     *
     * @param string|null $oldStateId
     * @param string|null $newStateId
     * @return bool
     */
    public function canChangeState(?string $oldStateId, ?string $newStateId): bool
    {
        if (($oldStateId == self::NONE) && ($newStateId == self::LIVE)) {
            return true;
        }
        if (($oldStateId == self::NONE) && ($newStateId == self::BAN)) {
            return false;
        }
        if (($oldStateId == self::LIVE) && ($newStateId == self::NONE)) {
            return false;
        }
        if (($oldStateId == self::LIVE) && ($newStateId == self::BAN)) {
            return true;
        }
        if (($oldStateId == self::BAN) && ($newStateId == self::NONE)) {
            return false;
        }
        if (($oldStateId == self::BAN) && ($newStateId == self::LIVE)) {
            return true;
        }

        return false;
    }

    /**
     * проверка доступа к приложению 
     * либо с токеном, либо без него в зависимости от настройки внутри Апп 
     */
    public static function checkAccessApiToToken(App $app, Request $request)
    {
        try {
            if (!$app->secure_api) {
                // good, go next step
                return true;
            } else {
                Token::where('token', $request->bearerToken())->firstOrFail();
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
}
