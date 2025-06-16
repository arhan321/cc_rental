@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productSchedule.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.product-schedules.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.productSchedule.fields.id') }}</th>
                        <td>{{ $productSchedule->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.productSchedule.fields.kostum_id') }}</th>
                        <td>{{ $productSchedule->kostum->nama_kostum ?? '' }}</td> <!-- Display Kostum Name -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.productSchedule.fields.tanggal_mulai') }}</th>
                        <td>{{ $productSchedule->tanggal_mulai }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.productSchedule.fields.tanggal_akhir') }}</th>
                        <td>{{ $productSchedule->tanggal_akhir }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.productSchedule.fields.jumlah_dibooking') }}</th>
                        <td>{{ $productSchedule->jumlah_dibooking }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.productSchedule.fields.status') }}</th>
                        <td>{{ $productSchedule->status }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.product-schedules.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
