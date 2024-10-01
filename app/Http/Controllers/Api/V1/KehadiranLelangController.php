<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\KehadiranLelang;
use App\Services\ZoomService;
use App\Notifications\KehadiranNotification;
use App\Http\Controllers\Controller;

class KehadiranLelangController extends Controller
{
    public function index()
    {
        // Ambil semua permohonan virtual milik penjual yang sedang login
        $requests = KehadiranLelang::where('seller_id', auth()->id())->get();
        return response()->json($requests);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'reason' => 'required|string',
        ]);

        $attendanceRequest = KehadiranLelang::create([
            'seller_id' => auth()->id(),
            'auction_id' => $validated['auction_id'],
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return response()->json($attendanceRequest, 201);
    }

    public function show($id)
    {
        $request = KehadiranLelang::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();
        return response()->json($request);
    }

    public function uploadLetter(Request $request, $id)
    {
        $validated = $request->validate([
            'letter' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('letter')->store('letters');

        $attendanceRequest = KehadiranLelang::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();
        $attendanceRequest->update(['letter_path' => $path]);

        return response()->json(['message' => 'Letter uploaded successfully']);
    }

    public function approve($id)
    {
        $attendanceRequest = KehadiranLelang::findOrFail($id);
        $attendanceRequest->update(['status' => 'approved']);

        // Menggunakan ZoomService untuk membuat link virtual
        $zoomLink = ZoomService::generateMeetingLink($attendanceRequest->auction);

        // Kirim notifikasi ke penjual
        $attendanceRequest->seller->notify(new KehadiranNotification($zoomLink, $attendanceRequest));

        return response()->json(['message' => 'Request approved and link sent']);
    }

    public function reject($id)
    {
        $attendanceRequest = KehadiranLelang::findOrFail($id);
        $attendanceRequest->update(['status' => 'rejected']);

        // Kirim notifikasi penolakan
        $attendanceRequest->seller->notify(new KehadiranNotification(null, $attendanceRequest));

        return response()->json(['message' => 'Request rejected']);
    }
}
