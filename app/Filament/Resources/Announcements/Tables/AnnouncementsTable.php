<?php

namespace App\Filament\Resources\Announcements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')
                    ->label('Message')
                    ->searchable()
                    ->limit(50)
                    ->weight('bold'),
                TextColumn::make('icon')
                    ->label('Icon')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('highlight')
                    ->label('Highlight')
                    ->placeholder('—'),
                ToggleColumn::make('is_active')
                    ->label('Active'),
                TextColumn::make('sort_order')
                    ->label('Sort')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
