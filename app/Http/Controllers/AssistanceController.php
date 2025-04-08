<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\DataTables\CmsDataTable;
use App\Services\AssistanceService;
use App\Http\Requests\AssistanceRequest;
use Illuminate\Support\Facades\Auth;

class AssistanceController extends Controller
{
    protected $assistanceService;
    public function __construct(AssistanceService $assistanceService)
    {
        $this->assistanceService = $assistanceService;
    }
    
    public function index(CmsDataTable $dataTable)
    {
        $page_title = 'Assistance';
        $resource = 'assistance';
        $column = ['name', 'remarks'];
        $data = Assistance::getAllAssistances();

        return $dataTable
            ->render('cms.index', compact(
                'dataTable',
                'page_title',
                'resource',
                'column',
                'data'
            ));
    }
    
    public function store(AssistanceRequest $request)
    {
        $assistance = $this->assistanceService->storeAssistance($request->validated());

        activity()
            ->performedOn($assistance)
            ->causedBy(Auth::user())
            ->log('Created a new assistance: ' . $assistance->name);

        return redirect()
            ->route(Auth::user()->getRoleNames()->first() . '.assistance.index')
            ->with('success', 'Assistance created successfully.');
    }
    
    public function update(AssistanceRequest $request, Assistance $assistance)
    {
        $assistance = $this->assistanceService->updateAssistance($request->validated(), $assistance);

        activity()
            ->performedOn($assistance)
            ->causedBy(Auth::user())
            ->log('Updated assistance: ' . $assistance->name);
            
        return redirect()
            ->route(Auth::user()->getRoleNames()->first() . '.assistance.index')
            ->with('success', 'Assistance updated successfully.');
    }
    
    public function destroy(Assistance $assistance)
    {
        $assistance = $this->assistanceService->deleteAssistance($assistance);
        
        activity()
            ->performedOn($assistance)
            ->causedBy(Auth::user())
            ->log('Deleted assistance: ' . $assistance->name);
            
        return redirect()
            ->route(Auth::user()->getRoleNames()->first() . '.assistance.index')
            ->with('success', 'Assistance deleted successfully.');
    }
}