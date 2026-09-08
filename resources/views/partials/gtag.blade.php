@php($googleAdsId = trim((string) ($studio['google_ads_id'] ?? '')))
@if($googleAdsId !== '')
    @php($googleAdsLabel = trim((string) ($studio['google_ads_conversion_label'] ?? '')))
    {{-- Google tag (gtag.js) — Google Реклама --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAdsId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json($googleAdsId));
        @if($googleAdsLabel !== '')
        {{-- Конверсия «Отправка формы для потенциальных клиентов»: засчитываем клик
             по кнопке онлайн-записи (запись ведёт во внешний YClients, своей формы нет). --}}
        document.addEventListener('click', function (e) {
            var link = e.target.closest('a[href]');
            if (link && /yclients\.(com|ru|by)/i.test(link.href)) {
                gtag('event', 'conversion', {'send_to': @json($googleAdsId.'/'.$googleAdsLabel)});
            }
        });
        @endif
    </script>
@endif
