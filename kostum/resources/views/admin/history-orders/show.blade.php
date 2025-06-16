@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.historyOrder.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.history-orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('cruds.historyOrder.fields.id') }}</label>
                        <p>{{ $historyOrder->id }}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.historyOrder.fields.order_id') }}</label>
                        <p>{{ $historyOrder->order->kode_order }}</p> <!-- Display Order Code -->
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.historyOrder.fields.tanggal_selesai') }}</label>
                        <p>{{ $historyOrder->tanggal_selesai }}</p> <!-- Display Tanggal Selesai -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('cruds.historyOrder.fields.total_bayar') }}</label>
                        <p>{{ $historyOrder->total_bayar }}</p> <!-- Display Total Bayar -->
                    </div>
                    <div class="form-group">
                        <label>{{ trans('cruds.historyOrder.fields.status') }}</label>
                        <p>{{ $historyOrder->status }}</p> <!-- Display Status -->
                    </div>
                </div>
            </div>

            <a class="btn btn-default mt-3" href="{{ route('admin.history-orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
