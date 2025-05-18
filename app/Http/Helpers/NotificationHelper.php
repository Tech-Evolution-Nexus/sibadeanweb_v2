<?php

namespace App\Http\Helpers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Http;

class NotificationHelper
{
    /**
     * Kirim pesan WhatsApp melalui Fonnte.
     */
    public static function sendFonnte(string $target, string $message): array
    {
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
            'countryCode' => '62',
        ]);

        return $response->json();
    }

    /**
     * Kirim notifikasi FCM ke satu device token.
     */
    public static function sendFcm(string $deviceToken, string $title, string $body): array
    {
        $messaging = self::messaging();

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create($title, $body));

        $result = $messaging->send($message);

        return ['status' => 'sent', 'result' => $result];
    }

    /**
     * Kirim data-only message ke satu token.
     */
    public static function sendFcmDataOnly(string $deviceToken, array $data): array
    {
        $messaging = self::messaging();

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withData($data);

        $result = $messaging->send($message);

        return ['status' => 'data_sent', 'result' => $result];
    }

    /**
     * Kirim FCM ke banyak device token sekaligus.
     */
    public static function broadcastFcm(array $deviceTokens, string $title, string $body): array
    {
        $messaging = self::messaging();
        $notification = Notification::create($title, $body);

        $messages = [];
        foreach ($deviceTokens as $token) {
            $messages[] = CloudMessage::withTarget('token', $token)
                ->withNotification($notification);
        }

        $report = $messaging->sendAll($messages);

        return [
            'successCount' => $report->successes()->count(),
            'failureCount' => $report->failures()->count(),
            'failures' => collect($report->failures())->map(function ($failure) {
                return [
                    'token' => $failure->target()->value(),
                    'error' => $failure->error()->getMessage(),
                ];
            })->all(),
        ];
    }

    /**
     * Kirim notifikasi ke semua pengguna yang subscribe ke topic tertentu.
     */
    public static function sendFcmToTopic(string $topicName, string $title, string $body): array
    {
        $messaging = self::messaging();
        $message = CloudMessage::withTarget('topic', $topicName)
            ->withNotification(Notification::create($title, $body));
        $result = $messaging->send($message);

        return ['status' => 'sent_to_topic', 'topic' => $topicName, 'result' => $result];
    }

    /**
     * Kirim notifikasi + data ke topic.
     */
    public static function sendFcmToTopicWithData(string $topicName, string $title, string $body, array $data): array
    {
        $messaging = self::messaging();

        $message = CloudMessage::withTarget('topic', $topicName)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        $result = $messaging->send($message);

        return ['status' => 'sent_with_data', 'topic' => $topicName, 'result' => $result];
    }

    /**
     * Broadcast ke semua user (topic "all_users").
     */
    public static function broadcastToAll(string $title, string $body): array
    {
        return self::sendFcmToTopic('all_users', $title, $body);
    }

    /**
     * Inisialisasi Firebase Messaging.
     */
    private static function messaging()
    {
        return (new Factory)->withServiceAccount(config('services.firebase.credentials'))
            ->createMessaging();
    }
}
