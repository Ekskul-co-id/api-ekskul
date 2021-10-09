<?php

namespace App\Http\Responses;

class PaginationResponse extends BaseResponse

{
    public function __construct($data, $total, $total_data, $offset, $limit, $errors = null, $message = 'success')
    {
        $meta = [
            'total_result' => $total,
            'total_data' => $total_data,
            'offset' => $offset,
            'limit' => $limit,
            'total_page' => $limit == 0 ? 0 : ceil($total / $limit),
            'current_page' => $limit == 0 ? 0 : floor($offset / $limit) + 1
        ];

        parent::__construct(200, $data, $errors, $message);
        $this->addCustomAttribute('meta', $meta);
    }
}
