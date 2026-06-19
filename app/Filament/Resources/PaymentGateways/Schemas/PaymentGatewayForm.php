<?php

namespace App\Filament\Resources\PaymentGateways\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentGatewayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->rows(2)
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            Toggle::make('is_active')
                                ->default(false),
                        ]),
                    ])->columnSpanFull(),

                Section::make('API Credentials')
                    ->description('Enter credentials from your bKash merchant dashboard')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('app_key')
                                ->label('App Key')
                                ->required()
                                ->default(fn ($record) => $record->credentials['app_key'] ?? ''),
                            TextInput::make('app_secret')
                                ->label('App Secret')
                                ->required()
                                ->password()
                                ->default(fn ($record) => $record->credentials['app_secret'] ?? ''),
                            TextInput::make('username')
                                ->label('Username')
                                ->required()
                                ->default(fn ($record) => $record->credentials['username'] ?? ''),
                            TextInput::make('password')
                                ->label('Password')
                                ->required()
                                ->password()
                                ->default(fn ($record) => $record->credentials['password'] ?? ''),
                        ]),
                    ])->columnSpanFull(),

                Section::make('Settings')
                    ->schema([
                        Grid::make(2)->schema([
                            Toggle::make('sandbox')
                                ->label('Sandbox Mode')
                                ->default(true)
                                ->default(fn ($record) => $record->settings['sandbox'] ?? true),
                            TextInput::make('callback_url')
                                ->label('Callback URL Override')
                                ->placeholder('Auto-generated if empty')
                                ->default(fn ($record) => $record->settings['callback_url'] ?? ''),
                        ]),
                    ])->columnSpanFull(),
            ]);
    }
}
