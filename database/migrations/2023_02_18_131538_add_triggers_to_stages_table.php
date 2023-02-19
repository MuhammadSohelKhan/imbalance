<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTriggersToStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = '
        DROP TRIGGER IF EXISTS `calculate_average_cycle_time2`;
        CREATE TRIGGER `calculate_average_cycle_time2` 
        AFTER INSERT ON `stages` 
        FOR EACH ROW 
        BEGIN 
        -- # declearing user variables
        SET @thisOperationID = NEW.operation_id, 
            @thisLineID = (SELECT `line_id` FROM `operations` WHERE `id` = @thisOperationID), 
            @avgCycleTime = ((SELECT AVG(first) + AVG(second) + AVG(third) + AVG(fourth) + AVG(fifth) FROM `stages` WHERE `operation_id` = @thisOperationID) / 5), 
            @thisLineAllowance = (SELECT `allowance` FROM `lines` where `id` = @thisLineID), 
            @cycleTimeWithAllowance = ((@avgCycleTime / 60) + ((@avgCycleTime / 60) * (@thisLineAllowance / 100))), 
            @dedicatedCycleTime = (@cycleTimeWithAllowance / (SELECT `allocated_man_power` FROM `operations` WHERE `id` = @thisOperationID)), 
            @capacityPerHour = (60 / @dedicatedCycleTime);

            UPDATE `operations` SET `average_cycle_time` = @avgCycleTime, `cycle_time_with_allowance` = @cycleTimeWithAllowance, `dedicated_cycle_time` = @dedicatedCycleTime, `capacity_per_hour` = @capacityPerHour WHERE `id` = @thisOperationID;
            
            UPDATE `lines` SET `possible_output` = (SELECT MIN(capacity_per_hour) FROM `operations` WHERE `line_id` = @thisLineID) WHERE `id` = @thisLineID;
        END;

        DROP TRIGGER IF EXISTS `update_average_cycle_time2`;
        CREATE TRIGGER `update_average_cycle_time2` 
        AFTER UPDATE ON `stages` 
        FOR EACH ROW 
        BEGIN 
        -- # declearing user variables
        SET @thisOperationID = NEW.operation_id, 
            @thisLineID = (SELECT `line_id` FROM `operations` WHERE `id` = @thisOperationID), 
            @avgCycleTime = ((SELECT AVG(first) + AVG(second) + AVG(third) + AVG(fourth) + AVG(fifth) FROM `stages` WHERE `operation_id` = @thisOperationID) / 5), 
            @thisLineAllowance = (SELECT `allowance` FROM `lines` where `id` = @thisLineID), 
            @cycleTimeWithAllowance = ((@avgCycleTime / 60) + ((@avgCycleTime / 60) * (@thisLineAllowance / 100))), 
            @dedicatedCycleTime = (@cycleTimeWithAllowance / (SELECT `allocated_man_power` FROM `operations` WHERE `id` = @thisOperationID)), 
            @capacityPerHour = (60 / @dedicatedCycleTime);

            UPDATE `operations` SET `average_cycle_time` = @avgCycleTime, `cycle_time_with_allowance` = @cycleTimeWithAllowance, `dedicated_cycle_time` = @dedicatedCycleTime, `capacity_per_hour` = @capacityPerHour WHERE `id` = @thisOperationID;
            
            UPDATE `lines` SET `possible_output` = (SELECT MIN(capacity_per_hour) FROM `operations` WHERE `line_id` = @thisLineID) WHERE `id` = @thisLineID;
          END
          ';

          DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = "DROP TRIGGER IF EXISTS calculate_average_cycle_time2; DROP TRIGGER IF EXISTS update_average_cycle_time2;";
        DB::connection()->getPdo()->exec($sql);
    }
}
