<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('message')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('icon')
                    ->label('Icon')
                    ->options([
                        'truck'    => 'Truck (Shipping)',
                        'tag'      => 'Tag (Discount)',
                        'clock'    => 'Clock (Returns)',
                        'star'     => 'Star (Quality)',
                        'sparkles' => 'Sparkles (Promo)',
                    ])
                    ->nullable(),
                TextInput::make('highlight')
                    ->label('Highlight Text')
                    ->helperText('Text to show in bold/highlight color within the message')
                    ->maxLength(100),
                Toggle::make('is_active')
                    ->default(true),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
