@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Selection (for the person placing the order) -->
            <div class="form-group">
                <label for="profile_id">{{ trans('cruds.order.fields.profile_id') }}</label>
                <select class="form-control {{ $errors->has('profile_id') ? 'is-invalid' : '' }}" name="profile_id" id="profile_id" required>
                    <option value disabled {{ old('profile_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($users as $user)
                        <option value="{{ optional($user->profile)->id }}" {{ old('profile_id', $order->profile_id) == optional($user->profile)->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('profile_id'))
                    <div class="invalid-feedback">{{ $errors->first('profile_id') }}</div>
                @endif
            </div>

            <!-- Kode Order -->
            <div class="form-group">
                <label for="kode_order">{{ trans('cruds.order.fields.kode_order') }}</label>
                <input class="form-control {{ $errors->has('kode_order') ? 'is-invalid' : '' }}" type="text" name="kode_order" id="kode_order" value="{{ old('kode_order', $order->kode_order) }}" readonly>
                @if($errors->has('kode_order'))
                    <div class="invalid-feedback">{{ $errors->first('kode_order') }}</div>
                @endif
            </div>

            <!-- Tanggal Sewa -->
            <div class="form-group">
                <label for="tanggal_sewa">{{ trans('cruds.order.fields.tanggal_sewa') }}</label>
                <input class="form-control {{ $errors->has('tanggal_sewa') ? 'is-invalid' : '' }}" type="date" name="tanggal_sewa" id="tanggal_sewa" value="{{ old('tanggal_sewa', $order->tanggal_sewa) }}" required>
                @if($errors->has('tanggal_sewa'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_sewa') }}</div>
                @endif
            </div>

            <!-- Tanggal Pengembalian -->
            <div class="form-group">
                <label for="tanggal_dikembalikan">{{ trans('cruds.order.fields.tanggal_dikembalikan') }}</label>
                <input class="form-control {{ $errors->has('tanggal_dikembalikan') ? 'is-invalid' : '' }}" type="date" name="tanggal_dikembalikan" id="tanggal_dikembalikan" value="{{ old('tanggal_dikembalikan', $order->tanggal_dikembalikan) }}" required>
                @if($errors->has('tanggal_dikembalikan'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_dikembalikan') }}</div>
                @endif
            </div>

            <!-- Total -->
            <div class="form-group">
                <label for="total">{{ trans('cruds.order.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', $order->total) }}" required>
                @if($errors->has('total'))
                    <div class="invalid-feedback">{{ $errors->first('total') }}</div>
                @endif
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="Menunggu" {{ old('status', $order->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ old('status', $order->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Siap Di Ambil" {{ old('status', $order->status) == 'Siap Di Ambil' ? 'selected' : '' }}>Siap Di Ambil</option>
                    <option value="Selesai" {{ old('status', $order->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                @endif
            </div>

            <!-- Order Items Selection -->
            <div class="form-group">
                <label for="items">{{ trans('cruds.order.fields.items') }}</label>
                <select class="form-control {{ $errors->has('items') ? 'is-invalid' : '' }}" name="items[]" id="items" multiple required>
                    @foreach($kostums as $kostum)
                        <option value="{{ $kostum->id }}" {{ in_array($kostum->id, old('items', $order->items->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $kostum->nama_kostum }} - Rp{{ number_format($kostum->harga_sewa) }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('items'))
                    <div class="invalid-feedback">{{ $errors->first('items') }}</div>
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
