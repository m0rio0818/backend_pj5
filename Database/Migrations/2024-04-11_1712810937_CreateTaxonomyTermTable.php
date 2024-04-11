<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateTaxonomyTermTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE taxonomy_term(
                taxonomyTermID INT PRIMARY KEY,
                taxonomyTermName VARCHAR(255),
                taxonomyTypeID INT,
                FOREIGN KEY (taxonomyTypeID) REFERENCES taxonomy(taxonomyID),
                description VARCHAR(255),
                parentTaxonomyTerm INT
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE taxonomy_term"
        ];
    }
}
