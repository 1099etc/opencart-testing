<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html  prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#" > <!--<![endif]-->
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />

<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
<meta name="description" content="The perfect, easy payroll solution for small and large businesses!"/>
<meta property='og:locale' content='en_US'/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="http://advancedmicrosolutions.net/"/>
<meta property="og:title" content="Welcome to 1099-etc.com!"/>
<meta property="og:description" content="The perfect, easy payroll solution for small and large businesses!"/>
<link rel="canonical" href="http://advancedmicrosolutions.net/" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Home - Welcome to 1099-etc.com!" />
<meta property="og:url" content="http://advancedmicrosolutions.net/" />
<meta property="og:site_name" content="Welcome to 1099-etc.com!" />
<link rel="alternate" type="application/rss+xml" title="Welcome to 1099-etc.com! &raquo; Feed" href="http://advancedmicrosolutions.net/feed/" />
<link rel="alternate" type="application/rss+xml" title="Welcome to 1099-etc.com! &raquo; Comments Feed" href="http://advancedmicrosolutions.net/comments/feed/" />
<meta name="copyright" content="Welcome to 1099-etc.com!" />
<meta name="language" content="en-US" />
<meta name="DC.Publisher" content="Welcome to 1099-etc.com!" />
<meta name="DC.Title" content="" />
<meta name="DC.Description" content="" />
<meta name="DC.Date" content="2014-06-17" />
<meta name="DC.date.issued" content="2014-06-17" />
<meta property="og:url" content="http://advancedmicrosolutions.net/" />
<meta property="og:title" content="" />
<meta property="og:description" content="" />
<meta property="og:site_name" content="Welcome to 1099-etc.com!" />
<meta property="og:type" content="article" />
<meta property="article:published_time" content="2014-03-28T16:45:41+00:00" />

<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="/images/favicon.ico" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<!-- <link rel="stylesheet" type="text/css" href="catalog/view/theme/amsTheme/stylesheet/stylesheet.css" /> -->
<link rel="stylesheet" type="text/css" href="catalog/view/theme/amsTheme/stylesheet/ams.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>


<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />

<script type="text/javascript" src="catalog/view/javascript/colorbox-master/jquery.colorbox.js"></script>

<script type="text/javascript" src="catalog/view/javascript/common.js"></script>

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/amsTheme/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/amsTheme/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->

<?php echo $google_analytics; ?>

<style type='text/css'>
input.uppercase { text-transform: uppercase; }
</style>

<script type='text/javascript'>
$(function() {
  $('input.uppercase').focusout(function() {
    // Uppercase-ize contents
    this.value = this.value.toLocaleUpperCase();
  });
});
</script>

</head>
<body>
<div id="container">
<div id="header">
  <?php if ($logo) { ?>
  <div id="logo"><a href="http://www.1099-etc.com/"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  <div id='topBlock'>
    <?php echo $language; ?>
    <?php echo $currency; ?>
    <?php echo $cart; ?>
      <div id="iconbar">
        <div id="facebook"><a href='http://www.facebook.com/pages/Edmond-OK/Advanced-Micro-Solutions/173502012883'><img src='catalog/view/theme/amsTheme/image/icon/transparent.png' alt='F' title='Facebook' /></a></div>
        <div id="linkedin"><a href='https://www.linkedin.com/company/advanced-micro-solutions?trk=company_name'><img src='catalog/view/theme/amsTheme/image/icon/transparent.png' alt='L' title='LinkedIN' /></a></div>
        <div id="twitter"><a href='http://www.twitter.com/1099etc'><img src='catalog/view/theme/amsTheme/image/icon/transparent.png' alt='T' title='Twitter' /></a></div>
        <div id="googleplus"><a href='https://plus.google.com/105065157490620971065/posts'><img src='catalog/view/theme/amsTheme/image/icon/transparent.png' alt='G' title='GooglePlus' /></a></div>
        <div id="email"><a href='http://www.1099-etc.com/contact-us/'><img src='catalog/view/theme/amsTheme/image/icon/transparent.png' alt='E' title='Contact Us' /></a></div>
      </div>

    <div id="search">
      <input type="text" name="search" placeholder="" value="<?php echo $search; ?>" />
      <div class="button-search"></div>
    </div>
  </div>
  <div id='midBlock'>
    <div id="welcome">
      <?php if (!$logged) { ?>
      <?php echo $text_welcome; ?>
      <?php } else { ?>
      <?php echo $text_logged; ?>
      <?php } ?>
    </div>
  </div>
  <div id='bottomBlock'>
    <div class="navigation-wrapper">
<?php

   $menu = file_get_contents('http://www.1099-etc.com/');


   $menuStart = strpos($menu, '<ul id="menu-main-1" class="sf-menu">');
   $menu = substr($menu, $menuStart);
   $menu = strstr($menu, "</div>", true);

   if(strpos($_SERVER['HTTP_HOST'], 'test.shop') !== false) {

     $menu = str_ireplace('https://shop.', 'http://test.shop.', $menu);
     $menu = str_ireplace('http://shop.', 'http://test.shop.', $menu);
   }
   echo $menu;

?>
    </div>
  </div>
</div>
<?php if ($categories) { ?>
<div id="menu">
  <ul>
    <?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>
      <div>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>
          <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>
<div id="notification"></div>
<div id="outterContent">
