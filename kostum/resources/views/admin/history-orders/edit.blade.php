@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.historyOrder.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.history-orders.update', [$historyOrder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Order Selection -->
            <div class="form-group">
                <label for="order_id">{{ trans('cruds.historyOrder.fields.order_id') }}</label>
                <select class="form-control {{ $errors->has('order_id') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    <option value disabled {{ old('order_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $historyOrder->order_id) == $order->id ? 'selected' : '' }}>
                            {{ $order->kode_order }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('order_id'))
                    <div class="invalid-feedback">{{ $errors->first('order_id') }}</div>
                @endif
            </div>

            <!-- Tanggal Selesai -->
            <div class="form-group">
                <label for="tanggal_selesai">{{ trans('cruds.historyOrder.fields.tanggal_selesai') }}</label>
                <input class="form-control {{ $errors->has('tanggal_selesai') ? 'is-invalid' : '' }}" type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai', $historyOrder->tanggal_selesai) }}" required>
                @if($errors->has('tanggal_selesai'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_selesai') }}</div>
                @endif
            </div>

            <!-- Total Bayar -->
            <div class="form-group">
                <label for="total_bayar">{{ trans('cruds.historyOrder.fields.total_bayar') }}</label>
                <input class="form-control {{ $errors->has('total_bayar') ? 'is-invalid' : '' }}" type="number" name="total_bayar" id="total_bayar" value="{{ old('total_bayar', $historyOrder->total_bayar) }}" required>
                @if($errors->has('total_bayar'))
                    <div class="invalid-feedback">{{ $errors->first('total_bayar') }}</div>
                @endif
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">{{ trans('cruds.historyOrder.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value="Selesai" {{ old('status', $historyOrder->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ old('status', $historyOrder->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
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
