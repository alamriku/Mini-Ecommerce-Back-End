<?php

use App\Enums\OrderStatus;

return [
    OrderStatus::APPROVED => 'Approved',
    OrderStatus::REJECTED => 'Rejected',
    OrderStatus::PROCESSING => 'Processing',
    OrderStatus::SHIPPED => 'Shipped',
    OrderStatus::DELIVERED => 'Delivered',
    OrderStatus::PENDING => 'Pending',
];
