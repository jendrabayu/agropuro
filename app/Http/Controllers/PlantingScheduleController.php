<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantingSchedule\PlantingScheduleStoreRequest;
use App\PlantingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlantingScheduleController extends Controller
{
    public function index()
    {
        return view('planting-schedule.index', [
            'schedules' => auth()->user()->PlantingSchedules()->latest()->get()
        ]);
    }

    public function show(Request $request, $id)
    {
        $schedule = auth()->user()->PlantingSchedules()->findOrFail($id);
        $activities = $schedule->PlantingScheduleDetails();

        if ($request->has('filterdate') && $request->filterdate === 'now') {
            $activities->where('date', now()->isoFormat('Y-M-D'));
        }

        $orderDate = 'desc';
        if ($request->has('orderdate') && in_array($request->orderdate, ['asc', 'desc'])) {
            $orderDate = $request->orderdate;
        }

        $activities = $activities->orderBy('date', $orderDate)->get();
        return view('planting-schedule.show', [
            'schedule' => $schedule,
            'activities' => $activities
        ]);
    }

    public function store(PlantingScheduleStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($request->title);

        $plantingSchedule = PlantingSchedule::create($validated);

        return  redirect()->route('plantingschedule.show',  $plantingSchedule->id)->with('info', 'Berhasil Membuat Penjadwalan Baru');
    }

    public function destroy($id)
    {
        PlantingSchedule::findOrFail($id)->delete();
        return redirect()->route('plantingschedule.index')->with('info', 'Penjadwalan Berhasil Dihapus');
    }
}
