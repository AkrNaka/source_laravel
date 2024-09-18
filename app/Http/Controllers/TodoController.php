<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    public function index() {
        try {
            $todos = Todo::all();
            return response()->json([
                'todos' => $todos
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching todos: ' . $e->getMessage());
            return response()->json([
                'error' => 'タスクの取得に失敗しました。'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $todo = Todo::create($request->only('title'));
            $todos = Todo::all();
            return response()->json(['todos' => $todos], 201);
        } catch (\Exception $e) {
            Log::error('Error creating todo: ' . $e->getMessage());
            return response()->json([
                'error' => 'タスクの作成に失敗しました。'
            ], 500);
        }
    }

    public function show($id) {
        try {
            $todo = Todo::find($id);

            if (!$todo) {
                return response()->json(['message' => 'タスクが見つかりませんでした。'], 404);
            }

            return response()->json(['todo' => $todo]);
        } catch (\Exception $e) {
            Log::error('Error fetching todo: ' . $e->getMessage());
            return response()->json([
                'error' => 'タスクの取得に失敗しました。'
            ], 500);
        }
    }


    public function update(Request $request, $id) {
        try {
            $todo = Todo::find($id);

            if (!$todo) {
                return response()->json(['message' => 'タスクが見つかりませんでした。'], 404);
            }

            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $todo->update($request->only('title'));

            return response()->json(['todo' => $todo]);
        } catch (\Exception $e) {
            Log::error('Error updating todo: ' . $e->getMessage());
            return response()->json([
                'error' => 'タスクの更新に失敗しました。'
            ], 500);
        }
    }
}
