<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos()->orderBy('created_at', 'desc')->get();
        $filter = 1;
        $sort = 1;

        // Define filter options and sort options
        $filterOptions = [
            '1' => 'All',
            '2' => 'Completed',
            '3' => 'Active',
            '4' => 'Has due date',
            '5' => 'No due date',
        ];

        $sortOptions = [
            '1' => 'Added date',
            '2' => 'Due date',
        ];

        // Pass todos, filter, and sort variables along with options to the view
        return view('todos', compact('todos', 'filter', 'sort', 'filterOptions', 'sortOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',

        ]);

        auth()->user()->todos()->create([
            'title' => $request->input('title'),
            'due_date' => ($request->input('due_date')) ? $request->input('due_date') : null,
        ]);

        return redirect()->back()->with('success', 'Todo created successfully.');
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'due_date' => 'required',
        ]);

        $todo->update([
            'title' => $request->input('title'),
            'due_date' => ($request->input('due_date')) ? $request->input('due_date') : null,
        ]);

        return redirect()->back()->with('success', 'Todo updated successfully.');
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter', '1'); // Default value is 1 (All)
        $sort = $request->input('sort', '1'); // Default value is 1 (Added date)

        // Query the todos belonging to the authenticated user
        $todos = Auth::user()->todos();

        if ($filter == '2') {
            $todos->where('completed', true);
        } elseif ($filter == '3') {
            $todos->where('completed', false);
        } elseif ($filter == '4') {
            $todos->whereNotNull('due_date');
        } elseif ($filter == '5') {
            $todos->whereNull('due_date');
        }

        if ($sort == '1') {
            $todos->orderBy('created_at', 'asc');
        } elseif ($sort == '2') {
            $todos->orderBy('due_date', 'asc');
        }

        $todos = $todos->get();

        // Define filter options and sort options
        $filterOptions = [
            '1' => 'All',
            '2' => 'Completed',
            '3' => 'Active',
            '4' => 'Has due date',
            '5' => 'No due date',
        ];

        $sortOptions = [
            '1' => 'Added date',
            '2' => 'Due date',
        ];

        // Pass todos, filter, and sort variables along with options to the view
        return view('todos', compact('todos', 'filter', 'sort', 'filterOptions', 'sortOptions'));
    }

    public function toggle(Request $request, Todo $todo)
    {
    $todo->update(['completed' => $request->has('completed')]);
    return redirect()->route('todos.index'); // Redirect back to the index page or any other route you desire.
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->back()->with('success', 'Todo deleted successfully.');
    }
}