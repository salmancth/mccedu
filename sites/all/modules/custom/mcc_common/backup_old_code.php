<?php

//upload_submtit

$url = "http://pdfx.cs.man.ac.uk";
$pdf = fopen($file_path, 'r');
$header = array('Content-Type: application/pdf', "Content-length: " . $size);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 200);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_INFILE, $pdf);
curl_setopt($ch, CURLOPT_INFILESIZE, $size);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$fp = fopen($save_path, "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
$url_param = '';
if ('bangla' == arg(1))
  $url_param = 'bangla';
if (!$res = curl_exec($ch)) {
  //echo "Error: " . curl_error($ch);
  drupal_set_message("Error: " . curl_error($ch), 'error');
  $redirect_url = '/upload-syllabus/' . $url_param;
} else {
  $_SESSION['syllabus_xml'] = $save_path;
  drupal_set_message("Successfully Parsed.");
  $redirect_url = '/parse-syllabus/' . $url_param;
}
curl_close($ch);



drupal_goto($redirect_url);


// parsing
//pretty_print($_SESSION['syllabus_xml']);
  if (!empty($_SESSION['syllabus_xml'])) {
    $xml_file_path = $_SESSION['syllabus_xml'];
    $xml = simplexml_load_file($xml_file_path) or die("Error: Cannot create object");
    $contents = $xml->article->body->section;
    //pretty_print($xml);
    $contents_array = null;
    foreach ($contents as $content) {
      if (!empty($content->h1)) {
        $title = strtolower($content->h1);
        if (strpos($title, 'introduction') === false &&
          strpos($title, 'appendix') === false &&
          strpos($title, 'materials') === false) {
          $dept_name = ltrim(mb_convert_encoding($content->h1, "HTML-ENTITIES", "UTF-8"), '0123456789. ');
          $dept_name = ucwords(strtolower(trim(str_replace('SYLLABUS', '', $dept_name))));
          //die($dept_name);
          $subject_itr = 1;
          foreach ($content->section as $content_section) {
            if (!empty($content_section->h2)) {
              $subject_name_str = ltrim(mb_convert_encoding($content_section->h2, "HTML-ENTITIES", "UTF-8"), '0123456789. ');
              $subject_array = explode(':', $subject_name_str);
              $codes_array = explode(' ', $subject_array[0]);
              $contents_array[$dept_name][$subject_itr]['subject'] = trim($subject_array[1]);
              $contents_array[$dept_name][$subject_itr]['code'] = trim($codes_array[1]);
              $contents_array[$dept_name]['dept_code'] = trim($codes_array[0]);
              foreach ($content_section->section as $content_section_section) {
                if (!empty($content_section_section->region)) {
                  if (!empty($content_section_section->h3)) {
                    $title_h3 = strtolower($content_section_section->h3);
                    $modified_title_h3 = ltrim(mb_convert_encoding($content_section_section->h3, "HTML-ENTITIES", "UTF-8"), '0123456789. ');
                    if (strpos($title_h3, 'materials') !== false) {
                      $contents_array[$dept_name][$subject_itr][$modified_title_h3] = _get_region_content($content_section_section->region, true);
                    } else {
                      $contents_array[$dept_name][$subject_itr][$modified_title_h3] = _get_region_content($content_section_section->region);
                    }
                  }
                }
              }
            }
            $subject_itr++;
          }
        }
      }
    }
    $vars['entry_form'] = drupal_get_form('syllabus_entry_form_auto', $contents_array);
    return theme('syllabus_entry_form_template', $vars);
  } else {
    drupal_goto(404);
  }

