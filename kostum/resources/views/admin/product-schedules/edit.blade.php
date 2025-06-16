@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.productSchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.product-schedules.update', [$productSchedule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Kostum Selection -->
            <div class="form-group">
                <label for="kostum_id">{{ trans('cruds.productSchedule.fields.kostum_id') }}</label>
                <select class="form-control {{ $errors->has('kostum_id') ? 'is-invalid' : '' }}" name="kostum_id" id="kostum_id" required>
                    <option value disabled {{ old('kostum_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($kostums as $kostum)
                        <option value="{{ $kostum->id }}" {{ old('kostum_id', $productSchedule->kostum_id) == $kostum->id ? 'selected' : '' }}>
                            {{ $kostum->nama_kostum }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('kostum_id'))
                    <div class="invalid-feedback">{{ $errors->first('kostum_id') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.productSchedule.fields.kostum_id_helper') }}</span>
            </div>

            <!-- Tanggal Mulai -->
            <div class="form-group">
                <label for="tanggal_mulai">{{ trans('cruds.productSchedule.fields.tanggal_mulai') }}</label>
                <input class="form-control {{ $errors->has('tanggal_mulai') ? 'is-invalid' : '' }}" type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', $productSchedule->tanggal_mulai) }}" required>
                @if($errors->has('tanggal_mulai'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_mulai') }}</div>
                @endif
            </div>

            <!-- Tanggal Akhir -->
            <div class="form-group">
                <label for="tanggal_akhir">{{ trans('cruds.productSchedule.fields.tanggal_akhir') }}</label>
                <input class="form-control {{ $errors->has('tanggal_akhir') ? 'is-invalid' : '' }}" type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ old('tanggal_akhir', $productSchedule->tanggal_akhir) }}" required>
                @if($errors->has('tanggal_akhir'))
                    <div class="invalid-feedback">{{ $errors->first('tanggal_akhir') }}</div>
                @endif
            </div>

            <!-- Jumlah Dibooking -->
            <div class="form-group">
                <label for="jumlah_dibooking">{{ trans('cruds.productSchedule.fields.jumlah_dibooking') }}</label>
                <input class="form-control {{ $errors->has('jumlah_dibooking') ? 'is-invalid' : '' }}" type="number" name="jumlah_dibooking" id="jumlah_dibooking" value="{{ old('jumlah_dibooking', $productSchedule->jumlah_dibooking) }}" required>
                @if($errors->has('jumlah_dibooking'))
                    <div class="invalid-feedback">{{ $errors->first('jumlah_dibooking') }}</div>
                @endif
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">{{ trans('cruds.productSchedule.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="Booked" {{ old('status', $productSchedule->status) == 'Booked' ? 'selected' : '' }}>Booked</option>
                    <option value="Selesai" {{ old('status', $productSchedule->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ old('status', $productSchedule->status) == 'Batal' ? 'selected' : '' }}>Batal</option>
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

@section('scripts')
<script>
    Dropzone.options.imageDropzone = {
        url: '{{ route('admin.kostums.storeMedia') }}',
        maxFilesize: 2, // MB
        acceptedFiles: '.jpeg,.jpg,.png,.gif',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
          size: 2,
          width: 4096,
          height: 4096
        },
        success: function (file, response) {
          $('form').find('input[name="image"]').remove()
          $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
        },
        removedfile: function (file) {
          file.previewElement.remove()
          if (file.status !== 'error') {
            $('form').find('input[name="image"]').remove()
            this.options.maxFiles = this.options.maxFiles + 1
          }
        },
        init: function () {
            @if(isset($kostum) && $kostum->image)
                var file = {!! json_encode($kostum->image) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            var message = typeof response === 'string' ? response : (response.errors.file || response)
            file.previewElement.classList.add('dz-error')
            let nodes = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            nodes.forEach(node => node.textContent = message)
        }
    }
</script>
@endsection
