@extends('layouts.admin')

@section('content')
@can('productschedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.product-schedules.create') }}">
                {{ trans('global.add') }} {{ trans('Product Schedules') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.productSchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-ProductSchedule">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.productSchedule.fields.id') }}</th>
                        <th>{{ trans('cruds.productSchedule.fields.kostum_id') }}</th>
                        <th>{{ trans('cruds.productSchedule.fields.tanggal_mulai') }}</th>
                        <th>{{ trans('cruds.productSchedule.fields.tanggal_akhir') }}</th>
                        <th>{{ trans('cruds.productSchedule.fields.jumlah_dibooking') }}</th>
                        <th>{{ trans('cruds.productSchedule.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productSchedules as $productSchedule)
                        <tr data-entry-id="{{ $productSchedule->id }}">
                            <td></td>
                            <td>{{ $productSchedule->id ?? '' }}</td>
                            <td>{{ $productSchedule->kostum->nama_kostum ?? '' }}</td> <!-- Display Kostum Name -->
                            <td>{{ $productSchedule->tanggal_mulai ?? '' }}</td>
                            <td>{{ $productSchedule->tanggal_akhir ?? '' }}</td>
                            <td>{{ $productSchedule->jumlah_dibooking ?? '' }}</td>
                            <td>{{ $productSchedule->status ?? '' }}</td>
                            <td>
                                @can('product_schedule_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.product-schedules.show', $productSchedule->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('product_schedule_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.product-schedules.edit', $productSchedule->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('product_schedule_delete')
                                    <form action="{{ route('admin.product-schedules.destroy', $productSchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        @can('product_schedule_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.product-schedules.massDestroy') }}",
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

        let table = $('.datatable-ProductSchedule:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
