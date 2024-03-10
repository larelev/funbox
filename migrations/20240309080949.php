<?php

return new class {
    public function up(): void
    {
        echo get_class($this) . __METHOD__ . " method called";
    }

    public function down(): void
    {
        echo get_class($this) . __METHOD__ . " method called";
    }
};