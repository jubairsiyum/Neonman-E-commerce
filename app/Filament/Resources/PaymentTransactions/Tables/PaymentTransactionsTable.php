<?php

namespace App\Filament\Resources\PaymentTransactions\Tables;

use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('order.order_number')
                    ->label('Order')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('gateway.name')
                    ->label('Gateway')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => strtoupper($state ?? '')),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('BDT', 0)
                    ->weight('bold'),

                TextColumn::make('trx_id')
                    ->label('Trx ID')
                    ->placeholder('—')
                    ->copyable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'processing' => 'info',
                        'failed' => 'danger',
                        'cancelled' => 'gray',
                        'refunded' => 'secondary',
                        default => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->label('Paid At')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                        'refunded' => 'Refunded',
                    ])
                    ->multiple(),
                SelectFilter::make('payment_gateway_id')
                    ->label('Gateway')
                    ->relationship('gateway', 'name'),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }
}
