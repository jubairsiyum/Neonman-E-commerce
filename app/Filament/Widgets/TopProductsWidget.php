<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopProductsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        // Build the aggregated subquery
        $sub = OrderItem::query()
            ->select(
                'product_id',
                'product_name',
                DB::raw('MIN(id)                    AS id'),
                DB::raw('SUM(quantity)               AS total_sold'),
                DB::raw('SUM(total)                  AS total_revenue'),
                DB::raw('COUNT(DISTINCT order_id)    AS order_count')
            )
            ->groupBy('product_id', 'product_name');

        // Set the model's table to the subquery alias so Filament generates
        // "top_products.id" instead of "order_items.id" in its secondary sort.
        $model = new OrderItem();
        $model->setTable('top_products');

        $query = $model->newQuery()
            ->fromSub($sub, 'top_products')
            ->orderByDesc('total_sold')
            ->limit(10);

        return $table
            ->heading('Best Selling Products')
            ->description('Top 10 products by units sold')
            ->query($query)
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->weight('semibold')
                    ->wrap()
                    ->description(fn ($record): string => 'SKU / ID: ' . ($record->product_id ?? '—')),

                Tables\Columns\TextColumn::make('total_sold')
                    ->label('Units Sold')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('order_count')
                    ->label('Orders')
                    ->numeric()
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Revenue')
                    ->money('BDT')
                    ->sortable()
                    ->weight('semibold')
                    ->color('success'),
            ]);
    }
}

