<div id="print-area">
    <table class="table table-hover table-bordered">
    <h4 class="header">@lang('site.client_name') : {{$order->client->name}}</h4>
    <h5>@lang('site.order_date') : {{$order->updated_at}}</h5>
        <thead>
        <tr>
            <th>@lang('site.name')</th>
            <th>@lang('site.quantity')</th>
            <th>@lang('site.price')</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h4>@lang('site.total') <span>{{ number_format($order->total_price, 2) }}</span></h4>

</div>

<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> @lang('site.print')</button>
