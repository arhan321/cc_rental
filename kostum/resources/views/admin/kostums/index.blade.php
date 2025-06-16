@extends('layouts.admin')

@section('content')
@can('kostum_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.kostums.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.kostum.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.kostum.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Kostum">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.kostum.fields.id') }}</th>
                        <th>{{ trans('cruds.kostum.fields.category_id') }}</th>
                        <th>{{ trans('cruds.kostum.fields.nama_kostum') }}</th>
                        <th>{{ trans('cruds.kostum.fields.ukuran') }}</th>
                        <th>{{ trans('cruds.kostum.fields.harga_sewa') }}</th>
                        <th>{{ trans('cruds.kostum.fields.stok') }}</th>
                        <th>{{ trans('cruds.kostum.fields.status') }}</th>
                        <th>{{ trans('cruds.kostum.fields.image') }}</th> <!-- Display image column -->
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kostums as $kostum)
                        <tr data-entry-id="{{ $kostum->id }}">
                            <td></td>
                            <td>{{ $kostum->id ?? '' }}</td>
                            <td>{{ $kostum->category->nama ?? '' }}</td> <!-- Display category name -->
                            <td>{{ $kostum->nama_kostum ?? '' }}</td>
                            <td>{{ $kostum->ukuran ?? '' }}</td>
                            <td>{{ $kostum->harga_sewa ?? '' }}</td>
                            <td>{{ $kostum->stok ?? '' }}</td>
                            <td>{{ $kostum->status ?? '' }}</td>
                            <td>
                                @if($kostum->image)
                                    <a href="{{ asset('storage/' . $kostum->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $kostum->image) }}" alt="Image" width="50" height="50" />
                                    </a>
                                @else
                                    {{ trans('global.no_image') }}
                                @endif
                            </td> <!-- Display image of kostum -->
                            <td>
                                @can('kostum_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.kostums.show', $kostum->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('kostum_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.kostums.edit', $kostum->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('kostum_delete')
                                    <form action="{{ route('admin.kostums.destroy', $kostum->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        @can('kostum_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.kostums.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }
                    }).done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 25,
        });

        let table = $('.datatable-Kostum:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
