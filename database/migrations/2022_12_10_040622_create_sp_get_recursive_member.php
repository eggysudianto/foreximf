<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpGetRecursiveMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
                CREATE PROCEDURE `sp_get_recursive_member`
                (
                    idmember INT,
                    statuses VARCHAR(20),
                    levels INT
                )
                BEGIN
                        DROP TEMPORARY TABLE IF EXISTS temp_member;
                        CREATE TEMPORARY TABLE IF NOT EXISTS temp_member
                        SELECT  id,
                            nama,
                            parent_id,
                            0 LEVEL
                        FROM    (SELECT * FROM members WHERE STATUS = 'aktif'
                             ORDER BY parent_id, id) members,
                            (SELECT @pv := idmember) initialisation
                        WHERE   FIND_IN_SET(parent_id, @pv) > 0
                        AND     @pv := CONCAT(@pv, ',', id);
                        
                        INSERT INTO temp_member
                        SELECT id, nama, parent_id, 0 FROM members 
                        WHERE parent_id IN (SELECT id FROM temp_member)
                        AND id NOT IN (SELECT id FROM temp_member)
                        AND STATUS = 'aktif';
                        
                        UPDATE temp_member
                        SET LEVEL = 1
                        WHERE parent_id = idmember;
                        
                        UPDATE temp_member
                        SET LEVEL = (SELECT LEVEL+1 FROM temp_member a WHERE temp_member.parent_id = a.id)
                        WHERE parent_id <> idmember;
                        
                        IF statuses='getlevel' THEN 
                            SELECT DISTINCT LEVEL FROM temp_member;
                        ELSEIF statuses='calculate' THEN
                            SELECT SUM(
                                CASE 
                                    WHEN LEVEL = '1' THEN 1
                                    WHEN LEVEL = '2' THEN 0.5
                                    ELSE 0
                                END
                                ) jumlah
                                        FROM temp_member
                                        WHERE LEVEL = levels;
                        ELSE
                            SELECT * FROM temp_member;
                        END IF;
                    END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_get_recursive_member');
    }
}
