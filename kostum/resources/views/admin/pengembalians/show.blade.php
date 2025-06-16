@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pengembalian.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.pengembalians.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.pengembalian.fields.id') }}</th>
                        <td>{{ $pengembalian->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengembalian.fields.order_item_id') }}</th>
                        <td>{{ $pengembalian->orderItem->kode_order }}</td> <!-- Display Order Code -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengembalian.fields.tanggal_kembali') }}</th>
                        <td>{{ $pengembalian->tanggal_kembali }}</td> <!-- Display Tanggal Kembali -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengembalian.fields.keterlambatan') }}</th>
                        <td>{{ $pengembalian->keterlambatan }}</td> <!-- Display Keterlambatan -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.pengembalian.fields.status') }}</th>
                        <td>{{ $pengembalian->status }}</td> <!-- Display Status -->
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.pengembalians.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
