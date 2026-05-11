<?php

if (!function_exists('pn_about_default_blocks')) {
    function pn_about_default_blocks(): array {
        return [
            'hero_title' => 'Về Nhà sách Phương Nam',
            'hero_text' => 'Nhà sách Phương Nam là đơn vị uy tín trong lĩnh vực phát hành và phân phối sách tại Việt Nam. '
                . 'Với cam kết mang đến nguồn tri thức phong phú, chúng tôi phục vụ hàng nghìn độc giả với '
                . 'chất lượng dịch vụ tốt nhất và giá cả hợp lý.',
            'intro_lead' => '',
            'mission_text' => 'Phát triển văn hóa đọc trong cộng đồng, góp phần nâng cao dân trí, xây dựng một xã hội '
                . 'học tập. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng cao với '
                . 'giá cả hợp lý và dịch vụ tốt nhất.',
            'vision_text' => 'Trở thành hệ thống phát hành sách hàng đầu Việt Nam, tiên phong trong việc ứng dụng '
                . 'công nghệ vào kinh doanh sách. Mở rộng mạng lưới phân phối đến mọi miền đất nước, '
                . 'đưa tri thức đến gần hơn với mọi người.',
            'value_cards' => [
                ['title' => 'Uy tín', 'text' => 'Luôn đặt uy tín lên hàng đầu trong mọi hoạt động kinh doanh, xây dựng niềm tin với khách hàng và đối tác.'],
                ['title' => 'Chất lượng', 'text' => 'Cam kết cung cấp sản phẩm chính hãng, chất lượng cao, đáp ứng nhu cầu đa dạng của khách hàng.'],
                ['title' => 'Đổi mới', 'text' => 'Không ngừng đổi mới, sáng tạo trong kinh doanh và dịch vụ, ứng dụng công nghệ hiện đại.'],
                ['title' => 'Tận tâm', 'text' => 'Phục vụ khách hàng với sự tận tâm, chu đáo, luôn lắng nghe và đáp ứng mọi nhu cầu.'],
                ['title' => 'Trách nhiệm', 'text' => 'Có trách nhiệm với cộng đồng, xã hội và môi trường, góp phần xây dựng xã hội phát triển bền vững.'],
                ['title' => 'Đoàn kết', 'text' => 'Xây dựng môi trường làm việc đoàn kết, hợp tác, tạo điều kiện cho nhân viên phát triển.'],
            ],
            'service_cards' => [
                ['title' => 'Giao hàng nhanh', 'text' => 'Giao hàng toàn quốc trong 2-3 ngày. Miễn phí vận chuyển cho đơn hàng từ 150.000đ.'],
                ['title' => 'Đổi trả dễ dàng', 'text' => 'Chính sách đổi trả linh hoạt trong vòng 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất.'],
                ['title' => 'Hỗ trợ 24/7', 'text' => 'Đội ngũ chăm sóc khách hàng chuyên nghiệp, sẵn sàng hỗ trợ bạn mọi lúc mọi nơi.'],
            ],
        ];
    }
}

if (!function_exists('pn_about_merge_card_arrays')) {
    function pn_about_merge_card_arrays(array $defaults, $saved): array {
        $out = $defaults;
        if (!is_array($saved)) {
            return $out;
        }
        foreach ($defaults as $i => $def) {
            if (!isset($saved[$i]) || !is_array($saved[$i])) {
                continue;
            }
            $row = $saved[$i];
            if (isset($row['title']) && is_string($row['title'])) {
                $out[$i]['title'] = $row['title'];
            }
            if (isset($row['text']) && is_string($row['text'])) {
                $out[$i]['text'] = $row['text'];
            }
        }

        return $out;
    }
}

if (!function_exists('pn_about_parse_blocks')) {
    function pn_about_parse_blocks(?string $dbRaw): array {
        $defaults = pn_about_default_blocks();
        $raw = trim((string) $dbRaw);
        if ($raw === '' || ($raw[0] ?? '') !== '{') {
            return $defaults;
        }
        $j = json_decode($raw, true);
        if (!is_array($j) || json_last_error() !== JSON_ERROR_NONE) {
            return $defaults;
        }

        $out = $defaults;
        foreach (['hero_title', 'hero_text', 'intro_lead', 'mission_text', 'vision_text'] as $key) {
            if (isset($j[$key]) && is_string($j[$key])) {
                $out[$key] = $j[$key];
            }
        }
        $out['value_cards'] = pn_about_merge_card_arrays($defaults['value_cards'], $j['value_cards'] ?? null);
        $out['service_cards'] = pn_about_merge_card_arrays($defaults['service_cards'], $j['service_cards'] ?? null);

        return $out;
    }
}
