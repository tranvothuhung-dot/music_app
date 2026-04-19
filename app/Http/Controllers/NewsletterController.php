<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterSubscriptionMail;
use App\Models\NewsletterSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Kiểm tra email đã đăng ký chưa
        if (NewsletterSubscription::isSubscribed($validated['email'])) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Email này đã đăng ký nhận tin rồi.',
                ], 409);
            }

            return back()->with('newsletter_subscribe_error', 'Email này đã đăng ký nhận tin rồi.');
        }

        try {
            // Lưu email vào database
            NewsletterSubscription::create([
                'email' => $validated['email'],
                'status' => 'active',
                'subscribed_at' => now(),
            ]);

            // Gửi email chào mừng
            Mail::to($validated['email'])->send(new NewsletterSubscriptionMail());
        } catch (\Throwable $exception) {
            Log::error('Newsletter subscription mail send failed', [
                'email' => $validated['email'],
                'exception' => $exception,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Đã xảy ra lỗi khi gửi mail đăng ký nhận tin. Vui lòng thử lại sau.',
                ], 500);
            }

            return back()->with('newsletter_subscribe_error', 'Đã xảy ra lỗi khi gửi mail đăng ký nhận tin. Vui lòng thử lại sau.');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Đăng ký nhận tin thành công. Vui lòng kiểm tra email của bạn.',
            ]);
        }

        return back()->with('newsletter_subscribe_success', 'Đăng ký nhận tin thành công. Vui lòng kiểm tra email của bạn.');
    }
}
