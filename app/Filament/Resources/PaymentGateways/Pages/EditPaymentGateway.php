<?php

namespace App\Filament\Resources\PaymentGateways\Pages;

use App\Filament\Resources\PaymentGateways\PaymentGatewayResource;
use Filament\Resources\Pages\EditRecord;

class EditPaymentGateway extends EditRecord
{
    protected static string $resource = PaymentGatewayResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->restructureData($data);
        return parent::mutateFormDataBeforeSave($data);
    }

    private function restructureData(array $data): array
    {
        $data['credentials'] = [
            'app_key'    => $data['app_key'] ?? '',
            'app_secret' => $data['app_secret'] ?? '',
            'username'   => $data['username'] ?? '',
            'password'   => $data['password'] ?? '',
        ];

        $data['settings'] = [
            'sandbox'      => $data['sandbox'] ?? true,
            'callback_url' => $data['callback_url'] ?? '',
        ];

        unset($data['app_key'], $data['app_secret'], $data['username'], $data['password'], $data['sandbox'], $data['callback_url']);

        return $data;
    }
}
