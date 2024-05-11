<?php

namespace Joaopaulolndev\FilamentGeneralSettings\Helpers;

use Joaopaulolndev\FilamentGeneralSettings\Enums\SocialNetworkEnum;

class SocialNetworkDataHelper
{
    public static function getSocialNetworkFromDatabase(array $data): array
    {
        $newValues = $data;

        foreach (SocialNetworkEnum::options() as $key => $value) {
            $newValues[$key] = $data['social_network'][$key] ?? null;
            unset($newValues['social_network']);
        }

        return $newValues;
    }

    public static function setSocialNetworkToDatabase($data): mixed
    {
        $data['social_network'] = [];

        foreach (SocialNetworkEnum::options() as $key => $value) {
            $data['social_network'][$key] = $data[$key] ?? null;
            unset($data[$key]);
        }

        return $data;
    }
}
