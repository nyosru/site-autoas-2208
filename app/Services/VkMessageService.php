<?php

namespace App\Services;

use App\Repositories\Contracts\VkSentMessageRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VkMessageService
{
    public function __construct(
        private  VkGroupMessageService $vkGroupMessageService,
        private  VkSentMessageRepositoryInterface $vkSentMessageRepository
    ) {
    }

    /**
     * Отправить сообщение от имени группы VK (service token).
     */
    public function sendFromGroup(int|string $vkId, string $message): bool
    {
        $messageId = (string) Str::ulid();

        if(1==1) {
            $this->vkSentMessageRepository->createPending($messageId, $vkId, $message, 'group');

            if (!$this->canSendFromGroup($vkId)) {
                $this->vkSentMessageRepository->markAsFailed($messageId, [
                    'message' => 'User is not eligible for group messages',
                    'vk_id' => (int)$vkId,
                ]);

                return false;
            }
        }

        $result = $this->vkGroupMessageService->sendToUserWithResult($vkId, $message);
        if (($result['success'] ?? false) === true) {
            $this->vkSentMessageRepository->markAsSent(
                $messageId,
                $result['provider_message_id'] ?? null,
                $result['response'] ?? null
            );

            return true;
        }

        $this->vkSentMessageRepository->markAsFailed(
            $messageId,
            $result['error'] ?? null,
            $result['response'] ?? null
        );

        return false;
    }

    /**
     * Проверить, можно ли отправить сообщение пользователю от имени группы.
     */
    public function canSendFromGroup(int|string $vkId): bool
    {
        return $this->vkGroupMessageService->canSendFromGroup($vkId);
    }

    /**
     * Отправить сообщение от имени пользователя (user access token).
     */
    public function sendWithAccessToken(string $accessToken, int|string $vkId, string $message): bool
    {
        $messageId = (string) Str::ulid();
        $this->vkSentMessageRepository->createPending($messageId, $vkId, $message, 'user_token');

        try {
            $response = Http::asForm()->timeout(30)->post('https://api.vk.com/method/messages.send', [
                'access_token' => $accessToken,
                'user_id' => (int) $vkId,
                'message' => trim($message),
                'random_id' => random_int(1, 2_147_483_647),
                'v' => '5.131',
            ]);

            $result = $response->json();

            if (isset($result['error'])) {
                Log::error('VK message error', [
                    'vk_id' => $vkId,
                    'error' => $result['error'],
                ]);

                $this->vkSentMessageRepository->markAsFailed($messageId, $result['error'], $result);

                return false;
            }

            $this->vkSentMessageRepository->markAsSent(
                $messageId,
                isset($result['response']) ? (string) $result['response'] : null,
                $result
            );

            return true;
        } catch (Exception $e) {
            Log::error('VK message exception', [
                'vk_id' => $vkId,
                'message' => $e->getMessage(),
            ]);

            $this->vkSentMessageRepository->markAsFailed($messageId, ['message' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Проверить валидность access token.
     */
    public function checkTokenValidity(string $accessToken): bool
    {
        try {
            $response = Http::timeout(10)->get('https://api.vk.com/method/users.get', [
                'access_token' => $accessToken,
                'v' => '5.131',
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            Log::error('VK token check exception', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Отправить уведомление пользователю через api.php-cat.com
     *
     * @param  string  $secret  Секретный ключ для api.php-cat.com (s параметр)
     * @param  int|string  $userId  ID пользователя VK
     * @param  string  $message  Текст сообщения
     * @param  string  $groupName  Название группы для уведомлений (по умолчанию 'notification')
     * @return array{success: bool, response?: array, error?: string}
     */
    public function sendNotification(string $secret, int|string $userId, string $message, string $groupName = 'notification'): array
    {
        Log::info('VkMessageService: sending notification', [
            'user_id' => $userId,
            'group_name' => $groupName,
        ]);

        try {
            $response = Http::timeout(6)->get('https://api.php-cat.com/api/vk/send', [
//                's' => $secret,
                'group_name' => $groupName,
                'user_id' => $userId,
                'message' => $message,
            ]);

            $result = $response->json();

            if ($response->failed()) {
                Log::error('VkMessageService: notification request failed', [
                    'status' => $response->status(),
                    'response' => $result,
                ]);
                return [
                    'success' => false,
                    'error' => "HTTP {$response->status()}",
                    'response' => $result,
                ];
            }

            if (isset($result['error'])) {
                Log::error('VkMessageService: notification error', [
                    'error' => $result['error'],
                    'user_id' => $userId,
                ]);
                return [
                    'success' => false,
                    'error' => $result['error'],
                    'response' => $result,
                ];
            }

            Log::info('VkMessageService: notification sent successfully', [
                'user_id' => $userId,
                'result' => $result,
            ]);

            return [
                'success' => true,
                'response' => $result,
            ];
        } catch (Exception $e) {
            Log::error('VkMessageService: notification exception', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
