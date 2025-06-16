@extends('layouts.admin')

@section('content')

@can('pengembalian_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pengembalians.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pengembalian.title') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('global.list') }} {{ trans('cruds.pengembalian.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Pengembalian">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.pengembalian.fields.id') }}</th>
                        <th>{{ trans('cruds.pengembalian.fields.order_item_id') }}</th>
                        <th>{{ trans('cruds.pengembalian.fields.tanggal_kembali') }}</th>
                        <th>{{ trans('cruds.pengembalian.fields.keterlambatan') }}</th>
                        <th>{{ trans('cruds.pengembalian.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengembalians as $pengembalian)
                        <tr data-entry-id="{{ $pengembalian->id }}">
                            <td></td>
                            <td>{{ $pengembalian->id }}</td>
                            <td>{{ $pengembalian->orderItem->kode_order ?? '' }}</td>
                            <td>{{ $pengembalian->tanggal_kembali ?? '' }}</td>
                            <td>{{ $pengembalian->keterlambatan ?? '' }}</td>
                            <td>{{ $pengembalian->status ?? '' }}</td>
                            <td>
                                @can('pengembalian_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pengembalians.edit', $pengembalian->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('pengembalian_delete')
                                    <form action="{{ route('admin.pengembalians.destroy', $pengembalian->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        @can('pengembalian_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.pengembalians.massDestroy') }}",
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

        let table = $('.datatable-Pengembalian:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
