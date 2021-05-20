<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySedRepitenciumRequest;
use App\Http\Requests\StoreSedRepitenciumRequest;
use App\Http\Requests\UpdateSedRepitenciumRequest;
use App\Models\SedRepitencium;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SedRepitenciaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sed_repitencium_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sedRepitencia = SedRepitencium::all();

        return view('admin.sedRepitencia.index', compact('sedRepitencia'));
    }

    public function create()
    {
        abort_if(Gate::denies('sed_repitencium_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sedRepitencia.create');
    }

    public function store(StoreSedRepitenciumRequest $request)
    {
        $sedRepitencium = SedRepitencium::create($request->all());

        return redirect()->route('admin.sed-repitencia.index');
    }

    public function edit(SedRepitencium $sedRepitencium)
    {
        abort_if(Gate::denies('sed_repitencium_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sedRepitencia.edit', compact('sedRepitencium'));
    }

    public function update(UpdateSedRepitenciumRequest $request, SedRepitencium $sedRepitencium)
    {
        $sedRepitencium->update($request->all());

        return redirect()->route('admin.sed-repitencia.index');
    }

    public function show(SedRepitencium $sedRepitencium)
    {
        abort_if(Gate::denies('sed_repitencium_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sedRepitencia.show', compact('sedRepitencium'));
    }

    public function destroy(SedRepitencium $sedRepitencium)
    {
        abort_if(Gate::denies('sed_repitencium_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sedRepitencium->delete();

        return back();
    }

    public function massDestroy(MassDestroySedRepitenciumRequest $request)
    {
        SedRepitencium::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
