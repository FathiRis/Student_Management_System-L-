<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassRoomController extends Controller
{
    public function index(): View
    {
        $classRooms = ClassRoom::latest()->paginate(10);

        return view('admin.class_rooms.index', compact('classRooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $classRoom = ClassRoom::create($request->validate([
            'name' => ['required', 'string', 'max:100'],
            'section' => ['nullable', 'string', 'max:100'],
        ]));

        ActivityLogger::log('class_room.created', $classRoom);

        return redirect()->route('admin.class-rooms.index')->with('success', 'Class added.');
    }
}
