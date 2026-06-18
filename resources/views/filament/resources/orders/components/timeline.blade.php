@php
    $statuses = [
        'pending'    => ['label' => 'Pending'],
        'paid'       => ['label' => 'Paid'],
        'processing' => ['label' => 'Processing'],
        'shipped'    => ['label' => 'Shipped'],
        'delivered'  => ['label' => 'Delivered'],
    ];

    $current = $order->status;
    $cancelled = $current === 'cancelled';
    $statusKeys = array_keys($statuses);
    $currentIndex = array_search($current, $statusKeys);
    if ($currentIndex === false) $currentIndex = -1;
@endphp

@if($cancelled)
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl" style="background: #fef2f2; border: 1px solid #fecaca;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p style="font-size: 14px; font-weight: 700; color: #dc2626;">Order Cancelled</p>
            <p style="font-size: 12px; color: #ef4444;">This order has been cancelled.</p>
        </div>
    </div>
@else
    <div style="display: flex; align-items: center; width: 100%; padding: 16px 16px 24px 16px;">
        @foreach($statuses as $key => $status)
            @php
                $done = $currentIndex !== false && $currentIndex >= array_search($key, $statusKeys);
                $isCurrent = $key === $current;
                $iconColor = ($isCurrent || $done) ? '#ffffff' : '#9ca3af';
            @endphp

            @if(!$loop->first)
                <div style="flex: 1; height: 3px; {{ $done ? 'background: #be185d;' : 'background: #e5e7eb;' }}"></div>
            @endif

            <div style="display: flex; flex-direction: column; align-items: center; position: relative; min-width: 56px;">
                @if($isCurrent)
                    <span style="position: absolute; top: -28px; padding: 2px 8px; background: #be185d; color: #fff; font-size: 9px; font-weight: 700; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Current</span>
                @endif

                <div style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                    {{ $isCurrent ? 'background: #be185d; box-shadow: 0 0 0 4px #fce7f3, 0 4px 6px -1px rgba(0,0,0,0.1);' : ($done ? 'background: #be185d;' : 'background: #f3f4f6; border: 2px solid #e5e7eb;') }}">

                    @if($key === 'pending')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @elseif($key === 'paid')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75H2.25a.75.75 0 01-.75-.75v-1.5a.75.75 0 01.75-.75h18z" />
                    </svg>
                    @elseif($key === 'processing')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    @elseif($key === 'shipped')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    @elseif($key === 'delivered')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                    @endif
                </div>

                <span style="margin-top: 6px; font-size: 10px; font-weight: 600; white-space: nowrap;
                    {{ $isCurrent ? 'color: #be185d;' : ($done ? 'color: #6b7280;' : 'color: #9ca3af;') }}">
                    {{ $status['label'] }}
                </span>
            </div>
        @endforeach
    </div>
@endif
