<?php

require(__DIR__ . '/../../_config/php/config.php');

/**
 * @param $userId int This is the user we plan to notify so we must act as them to create the post.
 * @return mixed
 */
function createPost ($userId) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => SE_URL . '/api/posts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'productId' => '@Acme/HelloWorld',
            'typeId' => 'acme:helloWorld:postNotify'
        )),
        CURLOPT_HTTPHEADER => array(
            'SE-Client: frontend',
            'SE-Api-Key: ' . SE_TOKEN,
            'SE-Viewer-Token: ' . SE_VIEWER_TOKEN,
            'SE-Act-As-Viewer: ' . $userId,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}

function createNotification ($postId) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => SE_URL . '/api/notifications',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'productId' => '@Acme/HelloWorld',
            'typeId' => 'acme:helloWorld:postNotify',
            'postId' => $postId
        )),
        CURLOPT_HTTPHEADER => array(
            'SE-Client: frontend',
            'SE-Api-Key: ' . SE_TOKEN,
            'SE-Viewer-Token: ' . SE_VIEWER_TOKEN,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}

/**
 * Change the ID here to a valid user ID on your site. Make sure not to choose the same user as your Viewer (e.g. SE_VIEWER_TOKEN).
 */
$post = createPost(66);

$notification = createNotification($post->id);

print_r($notification);
