<?php
function image_resize($filename, $width, $height, $opt = array()) {
  // 101115 Add icon layers to products images Begin
  $options = array('icon_24'   => array('image'    => '',
                                        'position' => 'topleft',
                                        'offset'   => array('top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0)),
                   'icon_new'  => array('image'   => '',
                                        'position' => 'bottomright',
                                        'offset'   => array('top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0)),
                   'icon_5'   => array('image'    => '',
                                        'position' => 'topleft',
                                        'offset'   => array('top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0)),
                   'image_name_only' => false
      );
  // To overide default options
  $result_options = arrayDeepMerge($options, $opt);
  // 101115 Add icon layers to products images End

 if (!file_exists(DIR_IMAGE . $filename)) {
  return;
 }
 
 $old_image = $filename;
 $new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.png';
 
 if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image)) || $result_options['icon_24']['image'] || $result_options['icon_new']['image'] || $result_options['icon_5']['image']) {
  $image = new Image(DIR_IMAGE . $old_image);
  if (!($width == 0 && $height == 0)) {
    $image->resize($width, $height);
  }
// 101115 Add icon layers to products images Begin
  if ($result_options['icon_24']['image'] && file_exists(DIR_IMAGE . $result_options['icon_24']['image'])) {
    $image->watermark_with_offset(DIR_IMAGE . $result_options['icon_24']['image'], $result_options['icon_24']['position'], $result_options['icon_24']['offset']['top'], $result_options['icon_24']['offset']['right'], $result_options['icon_24']['offset']['bottom'], $result_options['icon_24']['offset']['left']);
  }
  if ($result_options['icon_new']['image'] && file_exists(DIR_IMAGE . $result_options['icon_new']['image'])) {
    $image->watermark_with_offset(DIR_IMAGE . $result_options['icon_new']['image'], $result_options['icon_new']['position'], $result_options['icon_new']['offset']['top'], $result_options['icon_new']['offset']['right'], $result_options['icon_new']['offset']['bottom'], $result_options['icon_new']['offset']['left']);
  }
  // 101115 Add icon layers to products images End
  
  // 130829 ET-130815 Begin
  if ($result_options['icon_5']['image'] && file_exists(DIR_IMAGE . $result_options['icon_5']['image'])) {
    $image->watermark_with_offset(DIR_IMAGE . $result_options['icon_5']['image'], $result_options['icon_5']['position'], $result_options['icon_5']['offset']['top'], $result_options['icon_5']['offset']['right'], $result_options['icon_5']['offset']['bottom'], $result_options['icon_5']['offset']['left']);
  }
  // 130829 ET-130815 End
  
  $image->save(DIR_IMAGE . $new_image);
 }

 if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
   if ($result_options['image_name_only']) {
        return $new_image;
      } else {
        return HTTPS_IMAGE . $new_image; 
      }

 } else {
      if ($result_options['image_name_only']) {
        return $new_image;
      } else {
        return HTTP_IMAGE . $new_image;
      }
 } 
}
?>