@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.kostum.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.kostums.update', [$kostum->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Category Selection -->
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.kostum.fields.category_id') }}</label>
                <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                    <option value disabled {{ old('category_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $kostum->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('category_id'))
                    <div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.category_id_helper') }}</span>
            </div>

            <!-- Nama Kostum -->
            <div class="form-group">
                <label for="nama_kostum">{{ trans('cruds.kostum.fields.nama_kostum') }}</label>
                <input class="form-control {{ $errors->has('nama_kostum') ? 'is-invalid' : '' }}" type="text" name="nama_kostum" id="nama_kostum" value="{{ old('nama_kostum', $kostum->nama_kostum) }}" required>
                @if($errors->has('nama_kostum'))
                    <div class="invalid-feedback">{{ $errors->first('nama_kostum') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.nama_kostum_helper') }}</span>
            </div>

            <!-- Ukuran Kostum -->
            <div class="form-group">
                <label for="ukuran">{{ trans('cruds.kostum.fields.ukuran') }}</label>
                <select class="form-control {{ $errors->has('ukuran') ? 'is-invalid' : '' }}" name="ukuran" id="ukuran" required>
                    <option value disabled {{ old('ukuran', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="S" {{ old('ukuran', $kostum->ukuran) == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ old('ukuran', $kostum->ukuran) == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ old('ukuran', $kostum->ukuran) == 'L' ? 'selected' : '' }}>L</option>
                    <option value="One Size" {{ old('ukuran', $kostum->ukuran) == 'One Size' ? 'selected' : '' }}>One Size</option>
                </select>
                @if($errors->has('ukuran'))
                    <div class="invalid-feedback">{{ $errors->first('ukuran') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.ukuran_helper') }}</span>
            </div>

            <!-- Harga Sewa -->
            <div class="form-group">
                <label for="harga_sewa">{{ trans('cruds.kostum.fields.harga_sewa') }}</label>
                <input class="form-control {{ $errors->has('harga_sewa') ? 'is-invalid' : '' }}" type="number" name="harga_sewa" id="harga_sewa" value="{{ old('harga_sewa', $kostum->harga_sewa) }}" required>
                @if($errors->has('harga_sewa'))
                    <div class="invalid-feedback">{{ $errors->first('harga_sewa') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.harga_sewa_helper') }}</span>
            </div>

            <!-- Stok -->
            <div class="form-group">
                <label for="stok">{{ trans('cruds.kostum.fields.stok') }}</label>
                <input class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}" type="number" name="stok" id="stok" value="{{ old('stok', $kostum->stok) }}" required>
                @if($errors->has('stok'))
                    <div class="invalid-feedback">{{ $errors->first('stok') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.stok_helper') }}</span>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="deskripsi">{{ trans('cruds.kostum.fields.deskripsi') }}</label>
                <textarea class="form-control {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}" name="deskripsi" id="deskripsi">{{ old('deskripsi', $kostum->deskripsi) }}</textarea>
                @if($errors->has('deskripsi'))
                    <div class="invalid-feedback">{{ $errors->first('deskripsi') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.deskripsi_helper') }}</span>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">{{ trans('cruds.kostum.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    <option value="Tersedia" {{ old('status', $kostum->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Terbooking" {{ old('status', $kostum->status) == 'Terbooking' ? 'selected' : '' }}>Terbooking</option>
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                @endif
                <span class="help-block">{{ trans('cruds.kostum.fields.status_helper') }}</span>
            </div>

            <!-- Dropzone untuk Gambar Kostum -->
            <div class="form-group">
            <label for="image">{{ trans('cruds.kostum.fields.image') }}</label>
            <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone"></div>
            @if($errors->has('image'))
                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
            @endif
            <span class="help-block">{{ trans('cruds.kostum.fields.image_helper') }}</span>
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
