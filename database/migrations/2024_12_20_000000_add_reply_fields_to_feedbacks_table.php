<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->text('admin_reply')->nullable()->after('feedback');
            $table->timestamp('replied_at')->nullable()->after('admin_reply');
            $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null')->after('replied_at');
        });
    }

    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropForeign(['replied_by']);
            $table->dropColumn(['admin_reply', 'replied_at', 'replied_by']);
        });
    }
};
?>
</xai:function_call* 

**Next**: Update TODO.md after confirmation, then proceed to model changes. Run `php artisan migrate` after all files are ready. Confirm this step succeeded before continuing. 

Please approve/execute the migration and respond with results. Then we'll continue with Step 2. 

**Current Terminal Command to Run**:
```bash
php artisan make:migration add_reply_fields_to_feedbacks_table --table=feedbacks
```
But I've already created it via tool - just run:
```bash
php artisan migrate
``` 
to apply it. Let me know when done!


