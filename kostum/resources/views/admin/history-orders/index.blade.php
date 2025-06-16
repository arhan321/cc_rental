@extends('layouts.admin')

@section('content')
@can('history_order_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.history-orders.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.historyOrder.title') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.historyOrder.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-HistoryOrder">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.historyOrder.fields.id') }}</th>
                        <th>{{ trans('cruds.historyOrder.fields.order_id') }}</th>
                        <th>{{ trans('cruds.historyOrder.fields.tanggal_selesai') }}</th>
                        <th>{{ trans('cruds.historyOrder.fields.total_bayar') }}</th>
                        <th>{{ trans('cruds.historyOrder.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historyOrders as $historyOrder)
                        <tr data-entry-id="{{ $historyOrder->id }}">
                            <td></td>
                            <td>{{ $historyOrder->id ?? '' }}</td>
                            <td>{{ $historyOrder->order->kode_order ?? '' }}</td> <!-- Menampilkan kode order -->
                            <td>{{ $historyOrder->tanggal_selesai ?? '' }}</td>
                            <td>{{ $historyOrder->total_bayar ?? '' }}</td>
                            <td>{{ $historyOrder->status ?? '' }}</td>
                            <td>
                                @can('history_order_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.history-orders.show', $historyOrder->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('history_order_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.history-orders.edit', $historyOrder->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('history_order_delete')
                                    <form action="{{ route('admin.history-orders.destroy', $historyOrder->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        @can('history_order_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.history-orders.massDestroy') }}",
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

        let table = $('.datatable-HistoryOrder:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
