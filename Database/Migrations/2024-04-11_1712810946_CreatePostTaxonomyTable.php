<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostTaxonomyTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE postTaxonomy(
                postTaxonomyID INT,
                postID INT,
                FOREIGN KEY (postID) REFERENCES post(postID) ON DELETE CASCADE,
                taxonomyID INT,
                FOREIGN KEY (taxonomyID) REFERENCES taxonomy_term(taxonomyTermID) ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE postTaxonomy"
        ];
    }
}