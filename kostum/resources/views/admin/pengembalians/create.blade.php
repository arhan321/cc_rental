@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pengembalian.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.pengembalians.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Order Item Selection -->
            <div class="form-group">
                <label for="order_item_id">{{ trans('cruds.pengembalian.fields.order_item_id') }}</label>
                <select class="form-control {{ $errors->has('order_item_id') ? 'is-invalid' : '' }}" name="order_item_id" id="order_item_id" required>
                    <option value disabled {{ old('order_item_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($orderItems as $orderItem)
                        <option value="{{ $orderItem->id }}" {{ old('order_item_id') == $orderItem->id ? 'selected' : '' }}>
                            {{ $orderItem->kode_order }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('order_item_id'))
                    <div class="invalid-feedback">{{ $errors->first('order_item_id') }}</div>
                @endif
            </div>

            <!-- Tanggal Kembali -->
            <div class="form-group">
                <label for="tanggal_kembali">{{ trans('cruds.pengembalian.fields.tanggal_kembali') }}</label>
                <input class="form-control {{ $errors->has('tanggal_kembali') ? 'is-invalid' : '' }}" type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                @if($errors->has('tanggal_kembali'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_kembali') }}</div>
                @endif
            </div>

            <!-- Keterlambatan -->
            <div class="form-group">
                <label for="keterlambatan">{{ trans('cruds.pengembalian.fields.keterlambatan') }}</label>
                <input class="form-control {{ $errors->has('keterlambatan') ? 'is-invalid' : '' }}" type="number" name="keterlambatan" id="keterlambatan" value="{{ old('keterlambatan') }}">
                @if($errors->has('keterlambatan'))
                    <div class="invalid-feedback">{{ $errors->first('keterlambatan') }}</div>
                @endif
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">{{ trans('cruds.pengembalian.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value="Perlu Dikembalikan" {{ old('status') == 'Perlu Dikembalikan' ? 'selected' : '' }}>Perlu Dikembalikan</option>
                    <option value="Sudah Dikembalikan" {{ old('status') == 'Sudah Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                    <option value="Terlambat" {{ old('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
