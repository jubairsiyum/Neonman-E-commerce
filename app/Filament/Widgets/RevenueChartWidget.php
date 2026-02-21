<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected string $color = 'success';

    public ?string $filter = '6months';

    protected function getType(): string
    {
        return 'line';
    }

    public function getHeading(): ?string
    {
        return 'Revenue Overview';
    }

    public function getDescription(): ?string
    {
        return 'Paid orders revenue over time';
    }

    protected function getFilters(): ?array
    {
        return [
            '7days'   => 'Last 7 days',
            '30days'  => 'Last 30 days',
            '6months' => 'Last 6 months',
            '12months'=> 'Last 12 months',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? '6months';

        [$labels, $data] = match ($filter) {
            '7days'    => $this->dailyRevenue(7),
            '30days'   => $this->dailyRevenue(30),
            '12months' => $this->monthlyRevenue(12),
            default    => $this->monthlyRevenue(6),
        };

        return [
            'datasets' => [
                [
                    'label'                => 'Revenue (৳)',
                    'data'                 => $data,
                    'fill'                 => true,
                    'backgroundColor'      => 'rgba(225, 29, 72, 0.08)',
                    'borderColor'          => 'rgba(225, 29, 72, 0.85)',
                    'tension'              => 0.4,
                    'pointBackgroundColor' => 'rgb(225, 29, 72)',
                    'pointRadius'          => 3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function dailyRevenue(int $days): array
    {
        $labels = [];
        $data   = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date     = Carbon::now()->subDays($i);
            $labels[] = $date->format('M j');
            $data[]   = (float) Order::where('payment_status', Order::PAYMENT_PAID)
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        return [$labels, $data];
    }

    private function monthlyRevenue(int $months): array
    {
        $labels = [];
        $data   = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            $data[]   = (float) Order::where('payment_status', Order::PAYMENT_PAID)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
        }

        return [$labels, $data];
    }
}
