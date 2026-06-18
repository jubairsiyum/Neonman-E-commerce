<?php

namespace App\Filament\Resources\DeliveryZones\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DeliveryZoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('charge')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->suffix('BDT'),
                TextInput::make('free_shipping_threshold')
                    ->numeric()
                    ->nullable()
                    ->suffix('BDT')
                    ->helperText('Orders above this amount get free shipping. Leave empty for no free shipping.'),
                Toggle::make('is_active')
                    ->default(true),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
