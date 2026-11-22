<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatPrice(float|int $amount): string
{
    return 'KES ' . number_format((float) $amount, 2);
}

function getStockStatus(int $stock): array
{
    if ($stock === 0) {
        return ['label' => 'Sold out', 'class' => 'badge-sold-out'];
    } elseif ($stock <= 5) {
        return ['label' => 'Only ' . $stock . ' left', 'class' => 'badge-low-stock'];
    }
    return ['label' => 'In stock (' . $stock . ')', 'class' => 'badge-in-stock'];
}

function getCategories(array $products): array
{
    $categories = [];
    foreach ($products as $product) {
        $cat = $product['category'] ?? '';
        if ($cat !== '' && !in_array($cat, $categories, true)) {
            $categories[] = $cat;
        }
    }
    sort($categories);
    return $categories;
}