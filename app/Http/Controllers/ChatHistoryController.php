<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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

    /**
     * Receive incoming WhatsApp messages from gateway webhook.
     */
    public function webhook(Request $request): JsonResponse
    {
        $senderPhone = $request->input('sender.phone');
        $messageText = $request->input('message.text');

        if (! $senderPhone || ! $messageText) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sender phone number (sender.phone) and message text (message.text) are required.',
            ], 400);
        }

        Log::info('Chat message received', [
            'sender' => $senderPhone,
            'message' => $messageText,
        ]);

        // Clean and format WhatsApp phone number to standard 628...
        $formattedNumber = $this->formatWhatsAppNumber($senderPhone);

        // Find Customer by their formatted WhatsApp number
        $customer = Customer::where('whatsapp_number', $formattedNumber)->first();
        if (! $customer) {
            return response()->json([
                'status' => 'ignored',
                'message' => 'Message received but sender is not registered as a customer.',
            ], 200);
        }

        // Create the ChatHistory record
        $chat = ChatHistory::create([
            'customer_id' => $customer->id,
            'whatsapp_number' => $formattedNumber,
            'message' => $messageText,
        ]);

        // Increment total_chats_received for the customer (auto ++)
        $customer->increment('total_chats_received');

        // Update consultation_frequency if last_consultation_at is on a different day or null
        $now = now();
        if (is_null($customer->last_consultation_at) || ! now()->isSameDay($customer->last_consultation_at)) {
            $customer->increment('consultation_frequency');
            $customer->last_consultation_at = $now;
            $customer->save();
        }

        Log::info('Chat message processed successfully', [
            'customer_id' => $customer->id,
            'whatsapp_number' => $chat->whatsapp_number,
            'message' => $chat->message,
            'consultation_frequency' => $customer->consultation_frequency,
            'last_consultation_at' => $customer->last_consultation_at,
            'total_chats_received' => $customer->total_chats_received,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Chat message stored and analytics updated successfully.',
            'data' => [
                'id' => $chat->id,
                'customer' => $customer->full_name,
                'whatsapp_number' => $chat->whatsapp_number,
                'message' => $chat->message,
            ],
        ]);
    }

    /**
     * Normalize WhatsApp number to format: 628...
     */
    private function formatWhatsAppNumber(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            $digits = '62'.$digits;
        }

        return $digits;
    }
}
