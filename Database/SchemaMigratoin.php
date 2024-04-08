<?php

namespace Database;

interface SchemaMigratoin
{
    public function up(): array;
    public function down(): array;
}
