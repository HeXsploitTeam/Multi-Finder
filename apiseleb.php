<?php
class API
{
    public $api_url = "http://media-sellebgram.xyz/api/"; // API URL

    public $api_key = '
API-VXJq5DPIK5IpKWdPzU'; // Your API key

    public function order($data) { // add order
        $post = array_merge(array('api_key' => $this->api_key), $data);
        return json_decode($this->connect('/order.php', $post));
    }

    public function status($order_id) { // get order status
        return json_decode($this->connect('/status.php', array(
            'api_key' => $this->api_key,
            'order_id' => $order_id
            )));
    }

    public function profile() { // get order status
        return json_decode($this->connect('/profile.php', array(
            'api_key' => $this->api_key
            )));
    }
    private function connect($endpoint, $post) {
        $_post = Array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);
            }
        }
        $ch = curl_init($this->api_url . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}

// Examples

$api = new API();

$status = $api->profile(); // return profile

?>