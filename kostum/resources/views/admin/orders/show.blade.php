@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.order.fields.id') }}</th>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.order.fields.user_id') }}</th>
                        <td>{{ $order->user->name ?? $order->user->email ?? '' }}</td> <!-- Display User Name -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.order.fields.kode_order') }}</th>
                        <td>{{ $order->kode_order }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.order.fields.tanggal_order') }}</th>
                        <td>{{ $order->tanggal_order }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.order.fields.total') }}</th>
                        <td>{{ $order->total }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.order.fields.status') }}</th>
                        <td>{{ $order->status }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.orders.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
