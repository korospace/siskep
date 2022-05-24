<?php

namespace App\Utils;

class Utils {

    /**
     * Api response
     */
    static public function httpResponse(array $response): string
    {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($response['code']);
        echo json_encode($response);
        die;
    }

    /**
     * Cookie Option
     */
    static public function cookieOps(string $expired) : array
    {
        $cookie_options = array(
            'expires' => time() + $expired,
            'path' => '/',
            'domain' => base_url(), // leading dot for compatibility or use subdomain
            'secure' => true, // or false
            'httponly' => false, // or false
            'samesite' => 'None' // None || Lax || Strict
        );

        return $cookie_options;
    }

    /**
     * Remove Null Obj Element
     */
    public static function removeNullObjEl(Array $data): Array
    {
        foreach ($data as $key => $value) {
            if ($value == null) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * Modif Image Path
     */
    public static function modifImgPath($data,$targetKey,$targetPath): array
    {
        $newData = [];

        if (is_array($data)==false) {
            foreach ($data as $key => $value) {
                if($key == $targetKey){
                    $newData[$key] = base_url().$targetPath.$value;
                }
                else{
                    $newData[$key] = $value;
                }
            }
        } 
        else {

            foreach ($data as $array) {
                foreach ($array as $key => $value) {
                    if($key === $targetKey){
                        $array[$key] = base_url().$targetPath.$array[$targetKey];
                        $newData[]   = $array; 
                    }
                    
                }
            }
        }

        return (array)$newData;
    }

    /**
     * Method Parser.
     */
    public static function _methodParser(string $variableName): void
    {
        $putdata  = fopen("php://input", "r");
        $raw_data = '';

        while ($chunk = fread($putdata, 1024))
            $raw_data .= $chunk;

        fclose($putdata);

        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        if(empty($boundary)){
            parse_str($raw_data,$data);
            $GLOBALS[ $variableName ] = $data;
            return;
        }

        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data  = array();

        foreach ($parts as $part) {
            if ($part == "--\r\n") break;

            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

            $raw_headers = explode("\r\n", $raw_headers);
            $headers = array();
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            if (isset($headers['content-disposition'])) {
                $filename = null;
                $tmp_name = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                
                if(count($matches) !== 0){
                    list(, $type, $name) = $matches;
                }

                if( isset($matches[4]) )
                {
                    if( isset( $_FILES[ $matches[ 2 ] ] ) )
                    {
                        continue;
                    }

                    $filename       = $matches[4];
                    $filename_parts = pathinfo( $filename );
                    $tmp_name       = tempnam( ini_get('upload_tmp_dir'), $filename_parts['filename']);

                    $_FILES[ $matches[ 2 ] ] = array(
                        'error'=>0,
                        'name'=>$filename,
                        'tmp_name'=>$tmp_name,
                        'size'=>strlen( $body ),
                        'type'=>preg_replace('/\s+/', '', $value)
                    );

                    file_put_contents($tmp_name, $body);
                }
                else
                {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }

        }
        $GLOBALS[ $variableName ] = $data;
        return;
    }
}