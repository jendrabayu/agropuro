<?php

namespace App\Http\Controllers;

use App\PlantingSchedule;
use App\PlantingScheduleDetail;
use Illuminate\Http\Request;

class PlantingScheduleDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['planting_schedule_id' => ['required', 'numeric', 'exists:planting_schedules,id']]);

        $schedule = PlantingSchedule::findOrFail($request->planting_schedule_id);
        $validated = $this->validate($request, [
            'activity' => ['required', 'min:3', 'max:255', 'string'],
            'information' => ['nullable', 'string', 'min:5'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . $schedule->start_at, 'before_or_equal:' . $schedule->end_at],
        ], [], [
            'activity' => 'aktivitas',
            'information' => 'detail atau informasi',
            'date' => 'tanggal'
        ]);
        $validated['planting_schedule_id'] = $schedule->id;

        PlantingScheduleDetail::create($validated);
        return back()->with('info', 'Berhasil Membuat Aktivitas Baru');
    }

    public function edit($id)
    {
        $activity = PlantingScheduleDetail::findOrFail($id);
        $schedule = $activity->PlantingSchedule;
        abort_if($schedule->user_id !== auth()->id(), 404, 'Unauthorized');
        return view('planting-schedule.edit-activity', compact('activity', 'schedule'));
    }

    public function update(Request $request, $id)
    {

        $activity = PlantingScheduleDetail::findOrFail($id);
        $schedule = $activity->PlantingSchedule;
        abort_if($schedule->user_id !== auth()->id(), 404, 'Unauthorized');

        $validated = $this->validate($request, [
            'activity' => ['required', 'min:3', 'max:255', 'string'],
            'information' => ['nullable', 'string', 'min:5'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . $schedule->start_at, 'before_or_equal:' . $schedule->end_at],
        ], [], [
            'activity' => 'aktivitas',
            'information' => 'detail atau informasi',
            'date' => 'tanggal'
        ]);

        $activity->update($validated);
        return  redirect()->route('plantingschedule.show',  $schedule->id)->with('info', 'Data Aktivitas Berhasil Diperbarui');
    }

    public function destroy($id)
    {
        PlantingScheduleDetail::findOrFail($id)->delete();
        return back()->with('info', 'Aktivitas Berhasil Dihapus');
    }

    public function isDone(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric', 'exists:planting_schedule_details,id'],
            'is_done' => ['required', 'boolean']
        ]);

        PlantingScheduleDetail::findOrFail($request->id)->update($request->only('is_done'));
        return back()->with('info', 'Aktivitas ' . ($request->is_done ? 'Selesai' : 'Dibuka Kembali'));
    }
}
