<?php

namespace App\Services;

use Exception;
use Illuminate\Http\JsonResponse;

class HttpResponse extends JsonResponse
{


    /**
     * Create JSend response (https://github.com/omniti-labs/jsend)
     *
     * @param array|string $message Response message data
     * @param int   $responseCode default 200
     * @param string $status default 'request accepted'
     * @param int   $flags default 0
     */
    public function __construct(
        private array|string $message,
        private int $responseCode = 200,
        private string $status = 'request accepted',
        int $flags = 0
    ) {

        $data = [
            'status' => $status,
            'message' => $message,
        ];

        parent::__construct(
            status: $responseCode,
            data: $data,
            options: $flags
        );
    }
}
