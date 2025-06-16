@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.categories.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.categories.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.categories.fields.id') }}
                    </th>
                    <td>
                        {{ $category->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.categories.fields.nama') }}
                    </th>
                    <td>
                        {{ $category->nama }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.categories.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
