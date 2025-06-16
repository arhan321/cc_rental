@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.orderItem.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.order-items.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.id') }}</th>
                        <td>{{ $orderItem->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.order_id') }}</th>
                        <td>{{ $orderItem->order->kode_order }}</td> <!-- Display Order Code -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.kostum_id') }}</th>
                        <td>{{ $orderItem->kostum->nama_kostum }}</td> <!-- Display Kostum Name -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.qty') }}</th>
                        <td>{{ $orderItem->qty }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.durasi_sewa') }}</th>
                        <td>{{ $orderItem->durasi_sewa }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.tanggal_mulai') }}</th>
                        <td>{{ $orderItem->tanggal_mulai }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.tanggal_akhir') }}</th>
                        <td>{{ $orderItem->tanggal_akhir }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.harga_item') }}</th>
                        <td>{{ $orderItem->harga_item }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.total') }}</th>
                        <td>{{ $orderItem->total }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.orderItem.fields.status') }}</th>
                        <td>{{ $orderItem->status }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.order-items.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
