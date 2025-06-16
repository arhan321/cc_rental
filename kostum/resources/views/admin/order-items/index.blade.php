@extends('layouts.admin')

@section('content')

@can('order_item_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.order-items.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.orderItem.title') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('global.list') }} {{ trans('cruds.orderItem.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-OrderItem">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.orderItem.fields.id') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.order_id') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.kostum_id') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.qty') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.durasi_sewa') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.tanggal_mulai') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.tanggal_akhir') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.harga_item') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.total') }}</th>
                        <th>{{ trans('cruds.orderItem.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $orderItem)
                        <tr data-entry-id="{{ $orderItem->id }}">
                            <td></td>
                            <td>{{ $orderItem->id }}</td>
                            <td>{{ $orderItem->order->kode_order }}</td> <!-- Menampilkan kode order -->
                            <td>{{ $orderItem->kostum->nama_kostum }}</td> <!-- Menampilkan nama kostum -->
                            <td>{{ $orderItem->qty }}</td>
                            <td>{{ $orderItem->durasi_sewa }}</td>
                            <td>{{ $orderItem->tanggal_mulai }}</td>
                            <td>{{ $orderItem->tanggal_akhir }}</td>
                            <td>{{ $orderItem->harga_item }}</td>
                            <td>{{ $orderItem->total }}</td>
                            <td>{{ $orderItem->status }}</td>
                            <td>
                                @can('order_item_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.order-items.edit', $orderItem->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('order_item_delete')
                                    <form action="{{ route('admin.order-items.destroy', $orderItem->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display:inline-block;">
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

        @can('order_item_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.order-items.massDestroy') }}",
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

        let table = $('.datatable-OrderItem:not(.ajaxTable)').DataTable({ buttons: dtButtons })

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection
