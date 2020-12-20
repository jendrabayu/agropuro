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
