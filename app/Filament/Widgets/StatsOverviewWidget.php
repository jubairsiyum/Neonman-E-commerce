<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $now        = Carbon::now();
        $thisMonth  = Carbon::now()->startOfMonth();
        $lastMonth  = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // ── Revenue ───────────────────────────────────────────────────────────
        $totalRevenue      = Order::where('payment_status', Order::PAYMENT_PAID)->sum('total');
        $revenueThisMonth  = Order::where('payment_status', Order::PAYMENT_PAID)
                                  ->where('created_at', '>=', $thisMonth)->sum('total');
        $revenueLastMonth  = Order::where('payment_status', Order::PAYMENT_PAID)
                                  ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('total');
        $revenueDiff       = $revenueLastMonth > 0
                                ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
                                : ($revenueThisMonth > 0 ? 100 : 0);

        // ── Orders ────────────────────────────────────────────────────────────
        $totalOrders       = Order::count();
        $ordersThisMonth   = Order::where('created_at', '>=', $thisMonth)->count();
        $ordersLastMonth   = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();
        $ordersDiff        = $ordersLastMonth > 0
                                ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
                                : ($ordersThisMonth > 0 ? 100 : 0);

        // ── Customers ─────────────────────────────────────────────────────────
        $totalCustomers    = User::where('role', 'customer')->count();
        $newThisMonth      = User::where('role', 'customer')->where('created_at', '>=', $thisMonth)->count();
        $newLastMonth      = User::where('role', 'customer')
                                  ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();
        $customersDiff     = $newLastMonth > 0
                                ? round((($newThisMonth - $newLastMonth) / $newLastMonth) * 100, 1)
                                : ($newThisMonth > 0 ? 100 : 0);

        // ── Products ──────────────────────────────────────────────────────────
        $totalProducts     = Product::where('is_active', true)->count();
        $lowStock          = Product::where('is_active', true)->where('stock_quantity', '<=', 5)->count();

        // ── Pending orders ────────────────────────────────────────────────────
        $pendingOrders     = Order::where('status', Order::STATUS_PENDING)->count();

        // Revenue chart data (last 7 days)
        $revenueChart = collect(range(6, 0))->map(fn ($day) =>
            (float) Order::where('payment_status', Order::PAYMENT_PAID)
                ->whereDate('created_at', Carbon::now()->subDays($day))
                ->sum('total')
        )->values()->all();

        // Orders chart data (last 7 days)
        $ordersChart = collect(range(6, 0))->map(fn ($day) =>
            Order::whereDate('created_at', Carbon::now()->subDays($day))->count()
        )->values()->all();

        return [
            Stat::make('Total Revenue', '৳ ' . number_format($totalRevenue, 0))
                ->description(
                    ($revenueDiff >= 0 ? '↑ ' : '↓ ') . abs($revenueDiff) . '% vs last month'
                        . ' · ৳ ' . number_format($revenueThisMonth, 0) . ' this month'
                )
                ->descriptionColor($revenueDiff >= 0 ? 'success' : 'danger')
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('success')
                ->chart($revenueChart),

            Stat::make('Total Orders', number_format($totalOrders))
                ->description(
                    ($ordersDiff >= 0 ? '↑ ' : '↓ ') . abs($ordersDiff) . '% vs last month'
                        . ' · ' . $pendingOrders . ' pending'
                )
                ->descriptionColor($ordersDiff >= 0 ? 'success' : 'danger')
                ->icon(Heroicon::OutlinedShoppingCart)
                ->color('primary')
                ->chart($ordersChart),

            Stat::make('Total Customers', number_format($totalCustomers))
                ->description(
                    ($customersDiff >= 0 ? '↑ ' : '↓ ') . abs($customersDiff) . '% vs last month'
                        . ' · +' . $newThisMonth . ' new this month'
                )
                ->descriptionColor($customersDiff >= 0 ? 'success' : 'danger')
                ->icon(Heroicon::OutlinedUsers)
                ->color('info'),

            Stat::make('Active Products', number_format($totalProducts))
                ->description(
                    $lowStock > 0
                        ? $lowStock . ' product' . ($lowStock > 1 ? 's' : '') . ' low on stock'
                        : 'All products well-stocked'
                )
                ->descriptionColor($lowStock > 0 ? 'warning' : 'success')
                ->icon(Heroicon::OutlinedCube)
                ->color('warning'),
        ];
    }
}
