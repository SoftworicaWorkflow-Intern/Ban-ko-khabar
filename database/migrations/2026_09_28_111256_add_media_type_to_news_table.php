<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Media extensions grouped by the type they resolve to.
     *
     * @var array<string, list<string>>
     */
    private const EXTENSION_TYPES = [
        'image' => ['png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'avif', 'bmp', 'ico'],
        'video' => ['mp4', 'webm', 'mov', 'm4v', 'avi', 'mkv', 'ogv'],
        'audio' => ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac'],
        'document' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'zip'],
    ];

    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('media_type', 20)->default('image')->after('image_url')->index();
        });

        $this->backfillExistingMediaTypes();
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['media_type']);
            $table->dropColumn('media_type');
        });
    }

    /**
     * Existing rows are all image links, but URLs ending in .mp4 / .pdf and friends
     * should be typed correctly so the gallery filter is accurate from day one.
     */
    private function backfillExistingMediaTypes(): void
    {
        DB::table('news')->whereNotNull('image_url')->orderBy('id')->chunkById(200, function ($rows) {
            foreach ($rows as $row) {
                $extension = strtolower(pathinfo((string) parse_url($row->image_url, PHP_URL_PATH), PATHINFO_EXTENSION));

                foreach (self::EXTENSION_TYPES as $type => $extensions) {
                    if (in_array($extension, $extensions, true)) {
                        DB::table('news')->where('id', $row->id)->update(['media_type' => $type]);

                        break;
                    }
                }
            }
        });
    }
};
