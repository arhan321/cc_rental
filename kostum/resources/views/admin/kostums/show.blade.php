@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kostum.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default mb-3" href="{{ route('admin.kostums.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.id') }}</th>
                        <td>{{ $kostum->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.category_id') }}</th>
                        <td>{{ $kostum->category->nama ?? '' }}</td> <!-- Display category name -->
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.nama_kostum') }}</th>
                        <td>{{ $kostum->nama_kostum }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.ukuran') }}</th>
                        <td>{{ $kostum->ukuran }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.harga_sewa') }}</th>
                        <td>{{ $kostum->harga_sewa }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.stok') }}</th>
                        <td>{{ $kostum->stok }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.status') }}</th>
                        <td>{{ $kostum->status }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.kostum.fields.deskripsi') }}</th>
                        <td>{{ $kostum->deskripsi }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-default mt-3" href="{{ route('admin.kostums.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
