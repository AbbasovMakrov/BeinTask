<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE FUNCTION if not exists  `GetCategoryHierarchyLevelCount`(`parentCategoryId` BIGINT) RETURNS int
                DETERMINISTIC
            BEGIN
                DECLARE levelCount INT;

              WITH RECURSIVE CategoryHierarchy AS (
                SELECT DISTINCT id, name, parent_id, 1 AS level
                FROM categories
                WHERE parent_id IS NOT NULL
                AND parent_id = parentCategoryId

                UNION ALL

                SELECT c.id, c.name, c.parent_id, ch.level + 1 AS level
                FROM categories c
                JOIN CategoryHierarchy ch ON c.parent_id = ch.id
            )

            SELECT SUM(level_count) into levelCount
            FROM (
                SELECT parent_id,level, COUNT(DISTINCT parent_id) AS level_count
                FROM CategoryHierarchy
                GROUP BY level
            ) AS SubcategoryCounts;

                RETURN levelCount;
            END");
        DB::statement("

        CREATE  FUNCTION if not exists `GetUpperParentId`(`childId` INT) RETURNS int
            DETERMINISTIC
        BEGIN
            DECLARE upperParentId INT;

            WITH RECURSIVE CategoryPath AS (
                SELECT id, parent_id
                FROM categories
                WHERE id = childId

                UNION ALL

                SELECT c.id, c.parent_id
                FROM categories c
                JOIN CategoryPath cp ON c.id = cp.parent_id
            )
            SELECT id INTO upperParentId
            FROM CategoryPath
            ORDER BY id ASC
            LIMIT 1;

            RETURN upperParentId;
         END");
    }

    public function down(): void
    {
        DB::statement("DROP FUNCTION IF EXISTS GetCategoryHierarchyLevelCount");
        DB::statement("DROP FUNCTION IF EXISTS GetUpperParentId");

    }
};
