<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ])
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->helperText(fn ($get) => $get('type') === 'percentage' ? 'Percentage discount (e.g., 10 for 10%)' : 'Fixed amount in BDT'),
                TextInput::make('minimum_purchase')
                    ->numeric()
                    ->helperText('Minimum cart subtotal for this coupon to apply'),
                TextInput::make('maximum_discount')
                    ->numeric()
                    ->helperText('Maximum discount cap (for percentage coupons)'),
                TextInput::make('usage_limit')
                    ->numeric(),
                TextInput::make('used_count')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->disabled(),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('expires_at'),
                Toggle::make('is_active')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
