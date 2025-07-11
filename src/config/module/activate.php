<?php 
use WHMCS\Database\Capsule;

function autonotify_config () {
    /*
        $configurationFile = __DIR__ . '/../../../configuration.php';
        // Linha que você deseja verificar ou adicionar
        $api_access_key = '$api_access_key = "souREI-padrao123###";';
        if (strpos(file_get_contents($configurationFile), $api_access_key) === false) {
            // Adicionar a linha ao arquivo
            file_put_contents($configurationFile, $api_access_key . PHP_EOL, FILE_APPEND);
        } else {
            echo 'A linha já existe.';
        }
    */

    $dateCreated = date("d-m-Y H:i:s");
    $acceptNotificationExist = Capsule::table("tblcustomfields")->where("fieldname", "Aceita Notificações pelo WhatsApp? (Autonotify)")->exists();
    if (!$acceptNotificationExist) {
        Capsule::table("tblcustomfields")->insert([
            "type" => "client",
            "fieldname" => "Aceita Notificações pelo WhatsApp? (Autonotify)",
            "fieldtype" => "dropdown",
            "description" => "[Criado Automaticamente - {$dateCreated}]  Autonotify for WHMCS, não altere as informações desse campo.",
            "fieldoptions" => "Sim,Não",
            "adminonly" => "on",
            "sortorder" => 0
        ]);
    }

    if (!Capsule::schema()->hasTable('sr_autonotify_for_whmcs')) {
        Capsule::schema()->create('sr_autonotify_for_whmcs', function ($table) {
            $table->increments('id'); 
            $table->string('instance_key', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('system_status', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('admin_phone', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('intervalBetweenMessages', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('IntervalSeconds', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
        });
        Capsule::table("sr_autonotify_for_whmcs")->insert([
            "instance_key" => " ",
            "system_status" => " ",
            "admin_phone" => " ",
            "intervalBetweenMessages" => "Desativado",
            "IntervalSeconds" => ""
        ]);
    }

    if (!Capsule::schema()->hasTable('sr_templates_for_whmcs')) {
        Capsule::schema()->create('sr_templates_for_whmcs', function ($table) {
            $table->increments('id'); 
            $table->string('messageType', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('type', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('status', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->longText('message')->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('adminPhone', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('groupName', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->longText('variables')->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
        });
        $templatesJsonPath = __DIR__ . '/../../../public/json/templates.json';
        $templatesJson = file_get_contents($templatesJsonPath);
        $templatesArray = json_decode($templatesJson, true);    
        foreach ($templatesArray as $template) {
            Capsule::table("sr_templates_for_whmcs")->insert([
                "messageType" => $template["messageType"],
                "type" => $template["type"],
                "status" => $template["status"],
                "variables" => $template["variables"],
                "message" => $template["message"]
            ]);
        }
    }
    if (!Capsule::schema()->hasTable('sr_relatory_for_whmcs')) {
        Capsule::schema()->create('sr_relatory_for_whmcs', function ($table) {
            $table->increments('id'); 
            $table->string('type', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('clientId', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('name', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->string('phone', 50)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
            $table->longText('message')->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('sendDate', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('addedQueue', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('addedDate', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
            $table->string('status', 20)->nullable()->charset('latin1')->collation('latin1_swedish_ci');        
        });
    }
}

?>