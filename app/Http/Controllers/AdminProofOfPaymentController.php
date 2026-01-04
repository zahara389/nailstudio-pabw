<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminProofOfPaymentController extends Controller
{
    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()?->isAdmin(), 403);
    }

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
        $this->authorizeAdmin($request);

        $order = Order::with('user')->findOrFail($id);
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

        return view('admin.proof-of-payment', [
            'order' => $order,
            'metadata' => $metadata,
        ]);
    }

    public function image(Request $request, int $id): StreamedResponse
    {
        $this->authorizeAdmin($request);

        $order = Order::query()->findOrFail($id);
        abort_unless($order->proof_of_payment_path, 404);

        $disk = Storage::disk('public');
        $path = $this->normalizePublicDiskPath((string) $order->proof_of_payment_path);

        abort_unless($disk->exists($path), 404);

        return $disk->response($path);
    }
}
