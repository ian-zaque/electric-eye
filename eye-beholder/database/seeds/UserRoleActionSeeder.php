<?php

use Illuminate\Database\Seeder;
use App\UserRoleAction;

class UserRoleActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!UserRoleAction::first()){
            // Actions for COMUM
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "User";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "Region";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "InterestZone";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "Emergency";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "EmergencyParameter";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "Ude";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "Sensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "TypeSensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 1;
            $user_role_action->action = "View";
            $user_role_action->model = "MqttTopic";
            $user_role_action->save();
            ///////////////////////////////////////////////////////

            // Actions for ADMINISTRADOR
            ///////////// USER //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "User";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "User";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "User";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "User";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "User";
            $user_role_action->save();

            ///////////// REGION //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "Region";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "Region";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "Region";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "Region";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "Region";
            $user_role_action->save();

            ///////////// InterestZone //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "InterestZone";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "InterestZone";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "InterestZone";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "InterestZone";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "InterestZone";
            $user_role_action->save();

            ///////////// Emergency //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "Emergency";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "Emergency";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "Emergency";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "Emergency";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "Emergency";
            $user_role_action->save();

            ///////////// EmergencyParameter //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "EmergencyParameter";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "EmergencyParameter";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "EmergencyParameter";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "EmergencyParameter";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "EmergencyParameter";
            $user_role_action->save();

            ///////////// Ude //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "Ude";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "Ude";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "Ude";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "Ude";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "Ude";
            $user_role_action->save();

            ///////////// Sensor //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "Sensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "Sensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "Sensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "Sensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "Sensor";
            $user_role_action->save();

            ///////////// TypeSensor //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "TypeSensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "TypeSensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "TypeSensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "TypeSensor";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "TypeSensor";
            $user_role_action->save();

            ///////////// MqttTopic //////////////
            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "View";
            $user_role_action->model = "MqttTopic";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Create";
            $user_role_action->model = "MqttTopic";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Edit";
            $user_role_action->model = "MqttTopic";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Update";
            $user_role_action->model = "MqttTopic";
            $user_role_action->save();

            $user_role_action = new UserRoleAction();
            $user_role_action->user_role_id = 2;
            $user_role_action->action = "Delete";
            $user_role_action->model = "MqttTopic";
            $user_role_action->save();
        }
    }
}
