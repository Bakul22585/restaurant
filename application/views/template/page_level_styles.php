<?php 
$url = $this->uri->segment(1);
$addition_css = "";
if(!empty($url)){
    if($url == 'city'){
        $addition_css = "";
    }
    if($url == 'places'){
        $addition_css = '<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.css" rel="stylesheet" id="color_scheme">';
    }
    if($url == 'faq'){
        $addition_css = "";
    }
    if($url == 'restaurant'){
        $addition_css = '<link href="'.base_url(). 'public/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" id="color_scheme">';
    }
}
echo $addition_css;
?>