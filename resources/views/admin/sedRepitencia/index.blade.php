@extends('layouts.admin')
@section('content')
@can('sed_repitencium_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sed-repitencia.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sedRepitencium.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.sedRepitencium.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SedRepitencium">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.sedRepitencium.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.sedRepitencium.fields.poblacion') }}
                        </th>
                        <th>
                            {{ trans('cruds.sedRepitencium.fields.matricula') }}
                        </th>
                        <th>
                            {{ trans('cruds.sedRepitencium.fields.repitencia') }}
                        </th>
                        <th>
                            {{ trans('cruds.sedRepitencium.fields.fecha_corte') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sedRepitencia as $key => $sedRepitencium)
                        <tr data-entry-id="{{ $sedRepitencium->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $sedRepitencium->id ?? '' }}
                            </td>
                            <td>
                                {{ $sedRepitencium->poblacion ?? '' }}
                            </td>
                            <td>
                                {{ $sedRepitencium->matricula ?? '' }}
                            </td>
                            <td>
                                {{ $sedRepitencium->repitencia ?? '' }}
                            </td>
                            <td>
                                {{ $sedRepitencium->fecha_corte ?? '' }}
                            </td>
                            <td>
                                @can('sed_repitencium_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sed-repitencia.show', $sedRepitencium->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sed_repitencium_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sed-repitencia.edit', $sedRepitencium->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sed_repitencium_delete')
                                    <form action="{{ route('admin.sed-repitencia.destroy', $sedRepitencium->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
@can('sed_repitencium_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sed-repitencia.massDestroy') }}",
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-SedRepitencium:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('div#sidebar').on('transitionend', function(e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  })
  
})

</script>
@endsection