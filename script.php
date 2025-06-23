<?php

use Illuminate\Support\Facades\App;
use App\Models\Room;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rooms = Room::all();
echo "== Tổng số phòng: " . $rooms->count() . " ==\n";

foreach ($rooms as $room) {
    echo "- Room ID: {$room->id}, Tên: {$room->room_name}, Ảnh: {$room->image}\n";

    $filename = trim($room->image);

    // Nếu không có ảnh thì dùng ảnh mặc định
    if (!$filename) {
        $filename = 'upload/no_image.jpg';
    } elseif (!str_contains($filename, 'upload/')) {
        $filename = 'upload/roomimg/' . $filename;
    }

    $localPath = public_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filename));

    if (file_exists($localPath)) {
        echo "  ✅ Tìm thấy file: $localPath\n";

        try {
            $upload = Cloudinary::upload($localPath, ['folder' => 'roomimg']);
            $room->image = $upload->getSecurePath();
            $room->save();

            echo "  ✅ Uploaded room ID {$room->id} thành công\n";
        } catch (Exception $e) {
            echo "  ❌ Lỗi upload room ID {$room->id}: " . $e->getMessage() . "\n";
        }
    } else {
        echo "  ⚠️ Không tìm thấy ảnh hoặc đường dẫn sai: $localPath\n";
    }
}
