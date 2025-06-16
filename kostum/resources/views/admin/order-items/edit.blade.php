@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.orderItem.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.order-items.update', [$orderItem->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Order Selection -->
            <div class="form-group">
                <label for="order_id">{{ trans('cruds.orderItem.fields.order_id') }}</label>
                <select class="form-control {{ $errors->has('order_id') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    <option value disabled {{ old('order_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $orderItem->order_id) == $order->id ? 'selected' : '' }}>
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
                        <option value="{{ $kostum->id }}" {{ old('kostum_id', $orderItem->kostum_id) == $kostum->id ? 'selected' : '' }}>
                            {{ $kostum->nama_kostum }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('kostum_id'))
                    <div class="invalid-feedback">{{ $errors->first('kostum_id') }}</div>
                @endif
            </div>

            <!-- Other Fields (qty, duration, etc) -->

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
