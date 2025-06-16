@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.orderItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.order-items.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Order Selection -->
            <div class="form-group">
                <label for="order_id">{{ trans('cruds.orderItem.fields.order_id') }}</label>
                <select class="form-control {{ $errors->has('order_id') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    <option value disabled {{ old('order_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                            {{ $order->kode_order }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('order_id'))
                    <div class="invalid-feedback">{{ $errors->first('order_id') }}</div>
                @endif
            </div>

            <!-- Kostum Selection -->
            <div class="form-group">
                <label for="kostum_id">{{ trans('cruds.orderItem.fields.kostum_id') }}</label>
                <select class="form-control {{ $errors->has('kostum_id') ? 'is-invalid' : '' }}" name="kostum_id" id="kostum_id" required>
                    <option value disabled {{ old('kostum_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($kostums as $kostum)
                        <option value="{{ $kostum->id }}" {{ old('kostum_id') == $kostum->id ? 'selected' : '' }}>
                            {{ $kostum->nama_kostum }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('kostum_id'))
                    <div class="invalid-feedback">{{ $errors->first('kostum_id') }}</div>
                @endif
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="qty">{{ trans('cruds.orderItem.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" name="qty" id="qty" value="{{ old('qty') }}" required>
                @if($errors->has('qty'))
                    <div class="invalid-feedback">{{ $errors->first('qty') }}</div>
                @endif
            </div>

            <!-- Durasi Sewa -->
            <div class="form-group">
                <label for="durasi_sewa">{{ trans('cruds.orderItem.fields.durasi_sewa') }}</label>
                <input class="form-control {{ $errors->has('durasi_sewa') ? 'is-invalid' : '' }}" type="number" name="durasi_sewa" id="durasi_sewa" value="{{ old('durasi_sewa') }}" required>
                @if($errors->has('durasi_sewa'))
                    <div class="invalid-feedback">{{ $errors->first('durasi_sewa') }}</div>
                @endif
            </div>

            <!-- Tanggal Mulai -->
            <div class="form-group">
                <label for="tanggal_mulai">{{ trans('cruds.orderItem.fields.tanggal_mulai') }}</label>
                <input class="form-control {{ $errors->has('tanggal_mulai') ? 'is-invalid' : '' }}" type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                @if($errors->has('tanggal_mulai'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_mulai') }}</div>
                @endif
            </div>

            <!-- Tanggal Akhir -->
            <div class="form-group">
                <label for="tanggal_akhir">{{ trans('cruds.orderItem.fields.tanggal_akhir') }}</label>
                <input class="form-control {{ $errors->has('tanggal_akhir') ? 'is-invalid' : '' }}" type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required>
                @if($errors->has('tanggal_akhir'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_akhir') }}</div>
                @endif
            </div>

            <!-- Harga Item -->
            <div class="form-group">
                <label for="harga_item">{{ trans('cruds.orderItem.fields.harga_item') }}</label>
                <input class="form-control {{ $errors->has('harga_item') ? 'is-invalid' : '' }}" type="number" name="harga_item" id="harga_item" value="{{ old('harga_item') }}" required>
                @if($errors->has('harga_item'))
                    <div class="invalid-feedback">{{ $errors->first('harga_item') }}</div>
                @endif
            </div>

            <!-- Total -->
            <div class="form-group">
                <label for="total">{{ trans('cruds.orderItem.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total') }}" required>
                @if($errors->has('total'))
                    <div class="invalid-feedback">{{ $errors->first('total') }}</div>
                @endif
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">{{ trans('cruds.orderItem.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value="Perlu Dikembalikan" {{ old('status') == 'Perlu Dikembalikan' ? 'selected' : '' }}>Perlu Dikembalikan</option>
                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
