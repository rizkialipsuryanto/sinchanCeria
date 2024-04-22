
<?php


function bridgingAPI($method, $uri, $payload = null)
{
    $ci =   get_instance();
    $method = trim($method);
    $allowed_methods = array('GET', 'POST', 'PUT', 'DELETE');

    if (!in_array($method, $allowed_methods))
        throw new \Exception("'$method' is not valid cURL HTTP method.");


    // if (!empty($payload) && !is_string($payload))
    //     throw new \Exception("Invalid data for cURL request '$method $uri'");

    $ci->db->select('cons, secret, pcareuname, kdapk, pcarepass,uri_api');
    $ci->db->limit(1);
    $ci->db->order_by('id', 'ASC');
    $config = $ci->db->get_where('m_instansi')->row_array();


    $consID         = $config['cons'];
    $secretKey      = $config["secret"];
    $pcareUname     = $config["pcareuname"];
    $pcarePWD       = $config["pcarepass"];
    $kdAplikasi     = $config["kdapk"];

    date_default_timezone_set('UTC');
    $stamp = strval(time() - strtotime('1970-01-01 00:00:00'));

    $data         = $consID . '&' . $stamp;

    $signature = hash_hmac('sha256', $data, $secretKey, true);
    $encodedSignature = base64_encode($signature);

    $codedAuthorization = $pcareUname . ':' . $pcarePWD . ':' . $kdAplikasi;
    $encodedAuthorization = base64_encode($codedAuthorization);

    $url = $config["uri_api"] . "" . $uri;

    $headers = array(
        "Content-Type: application/json",
        "X-cons-id:" . $consID,
        "X-timestamp: " . $stamp,
        "X-signature: " . $encodedSignature,
        "X-authorization: Basic " . $encodedAuthorization
    );


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    switch ($method) {
        case 'GET':
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            break;
        case 'POST':
            // if (!is_string($payload))
            //     throw new \Exception("Invalid data for cURL request '$method $uri'");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            break;
        case 'PUT':
            // curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            break;
        case 'DELETE':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            break;
    }

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}



function _setformat($data)
{
    $ci =   get_instance();

    $eksekutif      =   $data["chkpoliesekutif"] ? $data["chkpoliesekutif"] : "0";
    $cob            = $data["chkCOB"] ?  $data["chkCOB"] : "0";
    $katarak        = $data["chkkatarak"] ?   $data["chkkatarak"] : "0";
    // $data  =
    //     [
    //         'request' => [
    //             't_sep' => [
    //                 'noKartu'   =>  $data["noka"],
    //                 'tglSep'   =>  $data["txttglsep"],
    //                 'ppkPelayanan'   =>  $data["kdPPkasalrujukan"],
    //                 'jnsPelayanan'   =>  null,
    //                 'klsRawat'   =>  $data["cb_kelasrawat"],
    //                 'noMR'   =>  $data["nomr"],
    //                 'rujukan'   =>  [
    //                     'asalRujukan'   =>  null,
    //                     'tglRujukan'   =>  $data["txttglrujukan"],
    //                     'noRujukan'   =>  $data["txtnorujukan"],
    //                     'ppkRujukan'   =>   null,
    //                 ],
    //                 'catatan'   =>   $data["txtcatatan"],
    //                 'diagAwal'   =>  $data["txt_kddiagnosa"],
    //                 'poli'   =>  [
    //                     'tujuan'   => null,
    //                     'eksekutif'   =>  $eksekutif,
    //                 ],
    //                 'cob'   =>  [
    //                     'cob'   =>  $cob,
    //                 ],
    //                 'katarak'   =>  [
    //                     'katarak'   =>  $katarak,
    //                 ],
    //                 'jaminan'   =>  [
    //                     'lakaLantas'   => $data["cb_statuskecelakaan"],
    //                     'penjamin'   =>  [
    //                         'penjamin'   =>  '',
    //                         'tglKejadian'   =>  '',
    //                         'keterangan'   =>  '',
    //                         'suplesi'   =>  [
    //                             'suplesi'   =>  "0",
    //                             'noSepSuplesi'   =>  '',
    //                             'lokasiLaka'   =>  [
    //                                 'kdPropinsi'   =>  '',
    //                                 'kdKabupaten'   =>  '',
    //                                 'kdKecamatan'   =>  ''
    //                             ]
    //                         ]
    //                     ],
    //                 ],
    //                 'skdp'   =>  [
    //                     'noSurat'   =>  $data["txtnospri"],
    //                     'kodeDPJP'   =>  $data["tx_kddpjp"],
    //                 ],
    //                 'noTelp'   =>  $data["txtnotelp"],
    //                 'user'   =>  null

    //             ]
    //         ]
    //     ];

    return $eksekutif;
}


function stringDecrypt($key, $string){
        $encrypt_method = 'AES-256-CBC';
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        printf($output);
        return $output;
    }