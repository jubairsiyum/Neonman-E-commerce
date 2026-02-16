<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // Product Images
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Product Images')
                    ->collection('images')
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(8)
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '3:4',
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->helperText('Upload up to 8 images. First image will be primary. Max 5MB each.')
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                    ->helperText('Product name'),
                
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->helperText('URL-friendly name'),
                
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                
                TextInput::make('sku')
                    ->label('SKU')
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique product ID'),
                
                Textarea::make('short_description')
                    ->maxLength(500)
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('Brief description (max 500 characters)'),
                
                Textarea::make('description')
                    ->required()
                    ->rows(6)
                    ->columnSpanFull()
                    ->helperText('Detailed product description'),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('৳')
                    ->minValue(0)
                    ->step(0.01)
                    ->helperText('Regular price'),
                
                TextInput::make('discount_price')
                    ->numeric()
                    ->prefix('৳')
                    ->minValue(0)
                    ->step(0.01)
                    ->lt('price')
                    ->helperText('Sale price (optional)'),
                
                TextInput::make('stock_quantity')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Available stock'),

                TagsInput::make('sizes')
                    ->placeholder('S, M, L, XL, XXL')
                    ->suggestions(['S', 'M', 'L', 'XL', 'XXL', '2XL', '3XL'])
                    ->helperText('Available sizes')
                    ->columnSpanFull(),
                
                TagsInput::make('colors')
                    ->placeholder('Black, White, Red')
                    ->suggestions(['Black', 'White', 'Red', 'Blue', 'Green', 'Gray', 'Navy', 'Maroon'])
                    ->helperText('Available colors')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->inline(false)
                    ->helperText('Visible on website'),
                
                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(false)
                    ->inline(false)
                    ->helperText('Show in featured section'),
                
                Toggle::make('is_new_arrival')
                    ->label('New Arrival')
                    ->default(false)
                    ->inline(false),
                
                Toggle::make('is_best_seller')
                    ->label('Best Seller')
                    ->default(false)
                    ->inline(false),
                
                TextInput::make('meta_title')
                    ->maxLength(60)
                    ->helperText('SEO title (max 60 characters)'),
                
                TextInput::make('meta_keywords')
                    ->helperText('SEO keywords'),
                
                Textarea::make('meta_description')
                    ->maxLength(160)
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('SEO description (max 160 characters)'),
            ]);
    }
}

