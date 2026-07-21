<?php

namespace App\Repositories\Eloquent;

use App\Models\VkSentMessage;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\VkSentMessageRepositoryInterface;

class VkSentMessageRepository extends BaseRepository implements VkSentMessageRepositoryInterface
{
    public function __construct(VkSentMessage $model)
    {
        parent::__construct($model);
    }

    public function createPending(string $id, int|string $vkId, string $message, string $channel): VkSentMessage
    {
        /** @var VkSentMessage $record */
        $record = $this->create([
            'id' => $id,
            'vk_id' => (int) $vkId,
            'message' => $message,
            'status' => VkSentMessage::STATUS_PENDING,
            'channel' => $channel,
        ]);

        return $record;
    }

    public function markAsSent(string $id, ?string $providerMessageId = null, ?array $response = null): bool
    {
        return $this->query()
            ->whereKey($id)
            ->update([
                'status' => VkSentMessage::STATUS_SENT,
                'provider_message_id' => $providerMessageId,
                'response' => $response,
                'error' => null,
                'sent_at' => now(),
                'failed_at' => null,
            ]) > 0;
    }

    public function markAsFailed(string $id, ?array $error = null, ?array $response = null): bool
    {
        return $this->query()
            ->whereKey($id)
            ->update([
                'status' => VkSentMessage::STATUS_FAILED,
                'response' => $response,
                'error' => $error,
                'failed_at' => now(),
            ]) > 0;
    }
}
