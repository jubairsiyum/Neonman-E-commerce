<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Orders')
            ->description('Latest 10 orders placed on the store')
            ->query(
                Order::query()
                    ->with(['user'])
                    ->latest()
                    ->limit(10)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->weight('semibold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->getStateUsing(fn (Order $record): string => $record->customer_name)
                    ->description(fn (Order $record): ?string => $record->customer_email),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('BDT')
                    ->weight('semibold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Order::STATUS_PENDING    => 'warning',
                        Order::STATUS_PAID       => 'info',
                        Order::STATUS_PROCESSING => 'primary',
                        Order::STATUS_SHIPPED    => 'primary',
                        Order::STATUS_DELIVERED  => 'success',
                        Order::STATUS_CANCELLED  => 'danger',
                        default                  => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Order::PAYMENT_PAID    => 'success',
                        Order::PAYMENT_FAILED  => 'danger',
                        default                => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y · g:i A')
                    ->sortable()
                    ->color('gray'),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon(Heroicon::OutlinedEye)
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.edit', $record))
                    ->openUrlInNewTab(),
            ]);
    }
}

