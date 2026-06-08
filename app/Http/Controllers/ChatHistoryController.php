<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ChatHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $perPage = $request->integer('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $chatHistories = ChatHistory::query()
            ->with('customer')
            ->when($search, function ($query, $search) {
                $query->where('whatsapp_number', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('dashboard.chat-histories.index', compact('chatHistories', 'search'));
    }

    public function destroy(ChatHistory $chatHistory): RedirectResponse
    {
        $chatHistory->delete();

        return redirect()->route('chat-histories.index')->with('success', 'Riwayat chat berhasil dihapus.');
    }
}
