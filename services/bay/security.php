<?php

define ('HMAC_SHA256', 'sha256');
define ('SECRET_KEY', 'c3fd7efb22d54e95b0fffc5aa073b3cd0482a5c42171417f949340b3da02787b71060b1feefb4b409582fa56d48c4772cb9b80a02bbe4566997f475365a30de61302667bd9be4a4a97c506250f6981b4acdf621dfae942e8ad95a71a6405c7c10d747bc673ad497a93efe1f874117abb40b4071b3a834395b28e011bc21b60fe');

function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as &$field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

?>
