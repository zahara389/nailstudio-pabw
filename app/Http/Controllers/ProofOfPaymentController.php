<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProofOfPaymentController extends Controller
{
    private function normalizePublicDiskPath(string $path): string
    {
        $path = ltrim($path, '/');

        // If DB accidentally stores "storage/proof_of_payments/...", strip the "storage/" prefix.
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        return $path;
    }

    public function show(Request $request, int $id): View
    {
        $order = Order::with('user')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        abort_unless($order->proof_of_payment_path, 404);

        $disk = Storage::disk('public');
    $path = $this->normalizePublicDiskPath((string) $order->proof_of_payment_path);

        abort_unless($disk->exists($path), 404);

        $sizeBytes = $disk->size($path);
        $mimeType = $disk->mimeType($path) ?? 'application/octet-stream';
        $lastModified = $disk->lastModified($path);

        $metadata = [
            'file_name' => basename($path),
            'path' => $path,
            'mime_type' => $mimeType,
            'size_bytes' => $sizeBytes,
            'last_modified' => Carbon::createFromTimestamp($lastModified),
        ];

        // Optional image dimension metadata (best-effort)
        try {
            $contents = $disk->get($path);
            $imageInfo = @getimagesizefromstring($contents);
            if (is_array($imageInfo)) {
                $metadata['width'] = $imageInfo[0] ?? null;
                $metadata['height'] = $imageInfo[1] ?? null;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return view('orders.proof-of-payment', [
            'order' => $order,
            'metadata' => $metadata,
        ]);
    }

    public function image(Request $request, int $id): StreamedResponse
    {
        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        abort_unless($order->proof_of_payment_path, 404);

        $disk = Storage::disk('public');
    $path = $this->normalizePublicDiskPath((string) $order->proof_of_payment_path);

        abort_unless($disk->exists($path), 404);

        return $disk->response($path);
    }
}
