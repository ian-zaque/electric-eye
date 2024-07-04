<?php

use Illuminate\Database\Seeder;
use App\MqttTopic;

class MqttTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!MqttTopic::first()){
            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "subscribe";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "As unidades de detecção recém conectados ao sistema enviam por esse tópico mensagens solicitando a inscrição na rede.";
            $mqtt_topic->save();

            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "update_node_table";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "Toda vez que uma nova UDE é inscrita no sistema, a tabela de unidade ativas atualizada é enviada por esse tópico para os MPCs. Dessa forma eles se mantém com as informações atualizadas do sistema para uma possível realização de uma requisição.";
            $mqtt_topic->save();

            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "config";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "Assim que uma unidade de detecção é inscrita no sistema, é enviada uma mensagem de configuração por esse tópico. As mensagens de configuração definem quais sensores serão ativos e seus respectivos valores limite, além de definir sua ZI de atuação e seu ID na rede.";
            $mqtt_topic->save();

            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "sensoring";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "Assim que uma unidade detecta um valor anômalo durante o processo de monitoramento, ela, a partir do envio de mensagens por esse canal de comunicação, notifica as unidades de detecção de maior poder computacional.";
            $mqtt_topic->save();

            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "request";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "Ao receber a notificação de um valor anômalo, as UDEs de maior poder computacional enviam requisições para outras unidades, para obter mais amostras daquele sinal e dos que são relacionados a ele. Esse tópico é definido para o envio dessas requisições.";
            $mqtt_topic->save();

            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "required_values";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "Ao receber uma requisiçãao, as unidades de detecção devem retornar o valor dos sinais solicitados. Esses valores são enviados a partir da utilização deste tópico.";
            $mqtt_topic->save();

            $mqtt_topic = new MqttTopic();
            $mqtt_topic->topic = "hazard_data";
            $mqtt_topic->active = 1;
            $mqtt_topic->description = "Tópico para o envio dos dados requisitados e que serão utilizados pelo controlador Fuzzy.";
            $mqtt_topic->save();
        }
    }
}
