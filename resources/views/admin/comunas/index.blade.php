@extends('layouts.admin')
@section('content')
@can('comuna_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.comunas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.comuna.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.comuna.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Comuna">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.comuna.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.comuna.fields.nombre') }}
                        </th>
                        <th>
                            {{ trans('cruds.comuna.fields.codigo') }}
                        </th>
                        <th>
                            {{ trans('cruds.comuna.fields.observaciones') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comunas as $key => $comuna)
                        <tr data-entry-id="{{ $comuna->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $comuna->id ?? '' }}
                            </td>
                            <td>
                                {{ $comuna->nombre ?? '' }}
                            </td>
                            <td>
                                {{ $comuna->codigo ?? '' }}
                            </td>
                            <td>
                                {{ $comuna->observaciones ?? '' }}
                            </td>
                            <td>
                                @can('comuna_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.comunas.show', $comuna->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('comuna_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.comunas.edit', $comuna->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('comuna_delete')
                                    <form action="{{ route('admin.comunas.destroy', $comuna->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('comuna_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.comunas.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-Comuna:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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