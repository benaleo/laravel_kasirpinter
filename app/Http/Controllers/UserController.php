<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('keyword')) {
            $keyword = strtolower($request->keyword);
            $query->where(function ($query) use ($keyword) {
                $query->whereRaw("LOWER(name) LIKE ?", ['%' . $keyword . '%'])
                    ->orWhereRaw("LOWER(email) LIKE ?", ['%' . $keyword . '%']);
            });
        }

        $users = $query
            ->when($request->sort, function ($query, $sort) {
                $direction = $request->direction ?? 'asc';
                $query->orderBy($sort, $direction);
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
