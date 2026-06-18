<?php
// 1. Định nghĩa link gốc cần bọc (Nekki)
$target_url = "https://sf2lb.nekkimobile.ru/balance";

// 2. Sử dụng cURL để bí mật lấy dữ liệu từ link gốc
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Tự động ngắt nếu server Nekki phản hồi quá 15 giây
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bỏ qua kiểm tra chứng chỉ SSL để tránh lỗi kết nối hụt

// Giả lập một trình duyệt thông thường gửi yêu cầu để Nekki không chặn
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

// Thực thi lấy dữ liệu
$response = curl_exec($ch);
curl_close($ch);

// 3. Xử lý và in kết quả ra ngoài cho Game hoặc Trình duyệt đọc
if ($response !== false) {
    // Ép định dạng trả về là JSON (y hệt cấu trúc gốc của Nekki)
    header('Content-Type: application/json; charset=utf-8');
    
    // Mở khóa CORS (Giúp game chạy trên Web/H5 hoặc các nền tảng khác gọi vào không bị lỗi bảo mật)
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    // In ra nội dung y hệt link gốc
    echo $response;
} else {
    // Trường hợp xấu nhất nếu link Nekki bị lỗi/sập, trả về một chuỗi JSON trống hợp lệ để game không bị crash (văng game)
    header('Content-Type: application/json; charset=utf-8');
    echo "{}";
}
?>
