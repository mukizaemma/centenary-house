<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Throwable;

class SafeMail
{
    /**
     * Run a mail send; log failures and return whether it succeeded.
     */
    public static function send(callable $callback): bool
    {
        try {
            $callback();

            return true;
        } catch (Throwable $e) {
            Log::warning('Mail delivery failed: '.$e->getMessage(), [
                'exception' => $e::class,
            ]);

            return false;
        }
    }

    /**
     * Public site: submission stored but outbound email could not be sent.
     */
    public static function receivedButNotificationFailed(): string
    {
        return 'Thank you! Your message has been received. We could not send email notifications right now, but we will still get back to you as soon as we can.';
    }

    /**
     * Admin: DB updated but visitor email failed.
     */
    public static function adminSavedButVisitorMailFailed(): string
    {
        return 'Response saved, but the email could not be sent to the visitor. Please contact them another way if needed.';
    }
}
