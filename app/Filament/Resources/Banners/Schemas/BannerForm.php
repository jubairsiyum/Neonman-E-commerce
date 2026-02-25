<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Banner Content')
                    ->description('This content will be displayed on the homepage carousel.')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(120)
                            ->columnSpanFull()
                            ->placeholder('e.g. New Collection — Summer 2026'),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(2)
                            ->maxLength(300)
                            ->placeholder('A short line shown below the title on the banner.'),
                        FileUpload::make('image')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('banners')
                            ->imagePreviewHeight('200')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(3072)
                            ->helperText('Recommended size: 1600 × 600 px. Max 3 MB. JPEG / PNG / WebP.')
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            TextInput::make('link')
                                ->label('Button URL')
                                ->url()
                                ->placeholder('https://... or /shop'),
                            TextInput::make('button_text')
                                ->label('Button Label')
                                ->maxLength(40)
                                ->placeholder('Shop Now'),
                        ]),
                    ]),

                Section::make('Scheduling & Visibility')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('sort_order')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->helperText('Lower number = shown first.'),
                            DateTimePicker::make('starts_at')
                                ->label('Start Date')
                                ->helperText('Leave blank to show immediately.'),
                            DateTimePicker::make('expires_at')
                                ->label('End Date')
                                ->helperText('Leave blank to never expire.'),
                        ]),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active banners appear on the homepage.'),
                    ]),
            ]);
    }
}
