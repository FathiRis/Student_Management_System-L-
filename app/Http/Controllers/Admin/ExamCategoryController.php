<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamCategory;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ExamCategory::latest()->paginate(10);

        return view('admin.exam_categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.exam_categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $category = ExamCategory::create($request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:exam_categories,name'],
            'description' => ['nullable', 'string'],
        ]));

        ActivityLogger::log('exam_category.created', $category);

        return redirect()->route('admin.exam-categories.index')->with('success', 'Exam category created.');
    }

    public function edit(ExamCategory $examCategory): View
    {
        return view('admin.exam_categories.edit', compact('examCategory'));
    }

    public function update(Request $request, ExamCategory $examCategory): RedirectResponse
    {
        $examCategory->update($request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:exam_categories,name,'.$examCategory->id],
            'description' => ['nullable', 'string'],
        ]));

        ActivityLogger::log('exam_category.updated', $examCategory);

        return redirect()->route('admin.exam-categories.index')->with('success', 'Exam category updated.');
    }

    public function destroy(ExamCategory $examCategory): RedirectResponse
    {
        $examCategory->forceDelete();
        ActivityLogger::log('exam_category.deleted', $examCategory);

        return redirect()->route('admin.exam-categories.index')->with('success', 'Exam category deleted.');
    }
}
