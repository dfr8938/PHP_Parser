<?php


class curl
{
    private $ch;                        // экземпляр curl
    private $host;                      // базовая часть url без слеша на конце

    private function __construct($host)
    {
        $this->ch = curl_init();
        $this->host = $host;
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public static function app($host)
    {
        return new self($host);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }

    public function set($option, $value)
    {
        curl_setopt($this->ch, $option, $value);
        return $this;
    }

    public function make_url($url)
    {
        if ($url[0] != '/')
            $url = '/' . $url;
        return $this->host . $url;
    }

    public function request($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->make_url($url));
        $data = curl_exec($this->ch);
        return $data;
    }
}
