<?php

namespace App\Repositories\Contracts;

use App\Models\VkSentMessage;

interface VkSentMessageRepositoryInterface
{
    public function createPending(string $id, int|string $vkId, string $message, string $channel): VkSentMessage;

    public function markAsSent(string $id, ?string $providerMessageId = null, ?array $response = null): bool;

    public function markAsFailed(string $id, ?array $error = null, ?array $response = null): bool;
}
