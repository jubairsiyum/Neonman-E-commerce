<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Section::make('Customer Information')
                        ->icon('heroicon-m-user')
                        ->schema([
                            TextEntry::make('customer_name')->label('Name')->weight('bold'),
                            TextEntry::make('customer_email')->label('Email'),
                            TextEntry::make('customer_phone')->label('Phone'),
                            TextEntry::make('user.name')->label('Customer Type')
                                ->state(fn (Order $record): string => $record->user ? 'Registered' : 'Guest'),
                        ])->columnSpan(1),

                    Section::make('Shipping Address')
                        ->icon('heroicon-m-map-pin')
                        ->schema([
                            TextEntry::make('shipping_address')->label('Address'),
                            Grid::make(3)->schema([
                                TextEntry::make('shipping_district')->label('District'),
                                TextEntry::make('shipping_division')->label('Division'),
                                TextEntry::make('shipping_postal_code')->label('Postal Code')
                                    ->state(fn (Order $record): string => $record->shipping_postal_code ?: 'N/A'),
                            ]),
                            TextEntry::make('shipping_phone')->label('Shipping Phone'),
                            TextEntry::make('deliveryZone.name')->label('Delivery Zone')
                                ->badge()
                                ->color('primary'),
                        ])->columnSpan(1),
                ])->columnSpanFull(),

                Section::make('Order Items')
                    ->icon('heroicon-m-shopping-bag')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                Grid::make(5)->schema([
                                    TextEntry::make('product_name')->label('Product')->weight('bold')->columnSpan(2),
                                    TextEntry::make('variant_details')->label('Variant')
                                        ->state(fn ($record): string => $record->variant_details ? implode(' / ', array_values(json_decode($record->variant_details, true) ?: [])) : 'Default'),
                                    TextEntry::make('quantity')->label('Qty'),
                                    TextEntry::make('price')->label('Unit Price')
                                        ->state(fn ($record): string => '৳' . number_format($record->price, 0)),
                                    TextEntry::make('total')->label('Total')
                                        ->state(fn ($record): string => '৳' . number_format($record->total, 0))
                                        ->weight('bold'),
                                ]),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                Grid::make(3)->schema([
                    Section::make('Order Summary')
                        ->icon('heroicon-m-calculator')
                        ->schema([
                            TextEntry::make('subtotal')->label('Subtotal')
                                ->state(fn (Order $record): string => '৳' . number_format($record->subtotal, 0)),
                            TextEntry::make('discount')->label('Discount')
                                ->state(fn (Order $record): string => $record->discount > 0 ? '-৳' . number_format($record->discount, 0) : '-'),
                            TextEntry::make('shipping_charge')->label('Shipping')
                                ->state(fn (Order $record): string => $record->shipping_charge > 0 ? '৳' . number_format($record->shipping_charge, 0) : 'FREE'),
                            TextEntry::make('tax')->label('Tax')
                                ->state(fn (Order $record): string => $record->tax > 0 ? '৳' . number_format($record->tax, 0) : '-'),
                            TextEntry::make('total')->label('Total')
                                ->state(fn (Order $record): string => '৳' . number_format($record->total, 0))
                                ->weight('bold')
                                ->size('lg'),
                        ])->columnSpan(1),

                    Section::make('Payment')
                        ->icon('heroicon-m-credit-card')
                        ->schema([
                            TextEntry::make('payment_method')->label('Method')
                                ->state(fn (Order $record): string => strtoupper($record->payment_method)),
                            TextEntry::make('payment_status')->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'failed' => 'danger',
                                    default => 'gray',
                                }),
                            TextEntry::make('bkash_transaction_id')->label('bKash Txn ID')
                                ->state(fn (Order $record): string => $record->bkash_transaction_id ?: 'N/A')
                                ->visible(fn (Order $record): bool => $record->payment_method === 'bkash'),
                            TextEntry::make('paid_at')->label('Paid At')
                                ->dateTime()
                                ->placeholder('N/A'),
                            TextEntry::make('coupon_code')->label('Coupon')
                                ->state(fn (Order $record): string => $record->coupon_code ?: '-')
                                ->color('primary'),
                        ])->columnSpan(1),

                    Section::make('Status & Notes')
                        ->icon('heroicon-m-clipboard-document-list')
                        ->schema([
                            TextEntry::make('status')->label('Order Status')->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'pending' => 'warning',
                                    'paid' => 'info',
                                    'processing' => 'primary',
                                    'shipped' => 'secondary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'gray',
                                }),
                            TextEntry::make('notes')->label('Customer Notes')
                                ->placeholder('No notes')
                                ->columnSpanFull(),
                            TextEntry::make('admin_notes')->label('Admin Notes')
                                ->placeholder('No admin notes')
                                ->columnSpanFull(),
                        ])->columnSpan(1),
                ])->columnSpanFull(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        $order = $this->record;

        return [
            Action::make('updateStatus')
                ->label('Update Status')
                ->icon('heroicon-m-arrow-path')
                ->color('warning')
                ->form(fn ($form) => $form->schema([
                    \Filament\Forms\Components\Select::make('status')
                        ->label('Order Status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default($order->status)
                        ->required(),
                    \Filament\Forms\Components\Select::make('payment_status')
                        ->label('Payment Status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'failed' => 'Failed',
                        ])
                        ->default($order->payment_status)
                        ->required(),
                ]))
                ->action(function (array $data, Order $record): void {
                    $record->update($data);
                    $this->notify('success', 'Order status updated.');
                }),

            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-m-pencil-square')
                ->url(fn () => $this->getResource()::getUrl('edit', ['record' => $this->record])),

            Action::make('print')
                ->label('Print Invoice')
                ->icon('heroicon-m-document-text')
                ->color('gray')
                ->url(fn () => route('admin.orders.print', $this->record->id)),

            Action::make('printSlip')
                ->label('Print Parcel Slip')
                ->icon('heroicon-m-document-check')
                ->color('info')
                ->url(fn () => route('admin.orders.print-slip', $this->record->id)),
        ];
    }
}
