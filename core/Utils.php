<?php

namespace PitouFW\Core;

use i18n;
use ReflectionClass;
use ReflectionProperty;

class Utils {
	public static function time(): int {
		$jet_lag = 0;
		return time() + (3600 * $jet_lag); 
	}

	public static function fromSnakeCaseToCamelCase(string $string): string {
		return preg_replace_callback("#_([a-z0-9])#", function (array $matches): string {
			return strtoupper($matches[1]);
		}, ucfirst($string));
	}

	public static function secure($data) {
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$data[$k] = self::secure($data[$k]);
			}
			return $data;
		}
		elseif (is_object($data)) {
			foreach ($data as $k => $v) {
				$data->$k = self::secure($data->$k);
			}
			$classname = get_class($data);
			$ref = new ReflectionClass($classname);
			$props = $ref->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
			foreach ($props as $prop) {
				$getter = 'get'.self::fromSnakeCaseToCamelCase($prop->getName());
				$setter = 'set'.self::fromSnakeCaseToCamelCase($prop->getName());
				if (method_exists($data, $getter) && method_exists($data, $setter)) {
					$data->$setter(self::secure($data->$getter()));
				}
			}
			return $data;
		}
		elseif (!is_string($data)) {
			return $data;
		}
		else {
			$data = htmlentities($data);
			return $data;
		}
	}

    public static function str2hex($string) {
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return $hex;
    }

    public static function hex2str($hex) {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

    public static function hashInfo($info) {
        return hash('sha512', $info);
    }

    public static function generateToken($length = 64) {
        if ($length % 4 !== 0) {
            return false;
        }

        $bytes_number = 0.75 * $length;
        return str_replace('+', '', str_replace('/', '', base64_encode(openssl_random_pseudo_bytes($bytes_number))));
    }

    public static function slugify($string, $delimiter = '-') {
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }

    public static function httpRequestInternal(string $url, string $method = 'GET', array $body = [], $access_token = JAM_INTERNAL_API_KEY): \stdClass {
        $postdata = http_build_query($body);
        $opts = ['http' => [
            'method' => $method,
            'header' => 'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
                'X-Access-Token: ' . $access_token . "\r\n",
            'content' => $postdata,
            'ignore_errors' => true
        ]];
        $context = stream_context_create($opts);

        return json_decode(file_get_contents($url, false, $context));
    }

    public static function hashEmail($email) {
        return self::hashInfo(strtolower($email));
    }
}