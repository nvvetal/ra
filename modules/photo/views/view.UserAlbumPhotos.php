<?php
function photoViewUserAlbumPhotos(View $View){
    $returnParams               = array();

    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $photoId                    = isset($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;
    $userId                     = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $perPage                    = 0;
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $Photos                     = new Photos($DBFactory->get_db_handle('rakscom'));
    $Photo                      = new Photo($DBFactory->get_db_handle('rakscom'));
    $userPhotos                 = $Photos->byOwner('user', $userId, $albumId, 'DESC', $page, $perPage);
    $userAlbum                  = new Album($DBFactory->get_db_handle('rakscom'));
    $userAlbum->findById($albumId);
    $sessionUserId              = $Session->get_value($sessionId,'user_id');

    if($userAlbum->owner_id == $sessionUserId && $userAlbum->owner_type == 'user' ) {
        header('Location: ?go=my_album_photos&album_id='.$albumId.'&s='.$sessionId.'&photo_id='.$photoId);
        exit;
    }

    if($userAlbum->owner_type == 'school' ) {
        header('Location: ?go=school_album_photos&album_id='.$albumId.'&s='.$sessionId.'&photo_id='.$photoId.'&school_id='.$userAlbum->owner_id);
        exit;
    }


    $returnParams['userAlbum']  = $userAlbum;
    $returnParams['userPhotos'] = $userPhotos;

    $Images  = Registry::get('Images');
    $Photo->findById($photoId);
    $templator = Registry::get('templator');
    $templator->assign('metaTitle', $Photo->name);
    $templator->assign('metaDescription', $Photo->description);
    $metaIMG = $GLOBALS['HTTP_IMAGES_PATH'].$Images->get_image_url_center_square($Photo->image_id, 500, 'jpg');
    $templator->assign('metaIMG', $metaIMG);

    return $returnParams;
}

