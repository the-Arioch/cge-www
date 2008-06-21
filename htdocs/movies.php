<?php
  require_once 'vrmlengine_functions.php';
  common_header("Demo movies - Kambi VRML game engine", LANG_EN);

  define(AVI_TITLE, 'Download AVI version');

  echo pretty_heading("Demo movies - Kambi VRML game engine");
?>

<p>Three demo videos showing our engine at work. YouTube videos have
quite bad quality, so you can download AVI versions with (slightly)
better quality.

<ol>
  <li><p>Demo movie from <?php echo a_href_page('"The Castle"', 'castle') ?> game
    (short gameplay sequences and shadow volumes fun):<br/>
    <?php echo current_www_a_href_size(AVI_TITLE, 'movies/1.avi'); ?>

    <?php

      /* Note that for HTML validity checking I must hide
         code to embed Flash. That's because it will simply not be
         valid, it's known and not really fixable, not without quite some
         Flash tricks, see
           http://www.alistapart.com/articles/flashsatay/
      */

    if (!HTML_VALIDATION) { ?>
    <p><object width="425" height="355"><param name="movie" value="http://www.youtube.com/v/qpUTK3_r7Lc&hl=en"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/qpUTK3_r7Lc&hl=en" type="application/x-shockwave-flash" wmode="transparent" width="425" height="355"></embed></object>
    <?php } ?>

  <li><p>Demo movie showing GLSL shaders and steep parallax mapping:<br/>
    <?php echo current_www_a_href_size(AVI_TITLE, 'movies/2.avi'); ?>

    <?php if (!HTML_VALIDATION) { ?>
    <p><object width="425" height="355"><param name="movie" value="http://www.youtube.com/v/ag-d-JGvHfQ&hl=en"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/ag-d-JGvHfQ&hl=en" type="application/x-shockwave-flash" wmode="transparent" width="425" height="355"></embed></object>
    <?php } ?>

  <li><p>Demo movie from "The Rift", more a draft than a real game for now, see
    <a href="http://mileofcry.wordpress.com/">Mile Of Cry game blog</a>:<br/>
    <?php echo current_www_a_href_size(AVI_TITLE, 'movies/3.avi'); ?>

    <?php if (!HTML_VALIDATION) { ?>
    <p><object width="425" height="355"><param name="movie" value="http://www.youtube.com/v/daIrz3ehN_I&hl=en"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/daIrz3ehN_I&hl=en" type="application/x-shockwave-flash" wmode="transparent" width="425" height="355"></embed></object>
    <?php } ?>
</ol>

<p>Recorded on 2008-05-01. Production entirely on Linux by free software:
capture thanks to <a href="http://dbservice.com/projects/yukon/wiki">Yukon
(OpenGL video capturing framework)</a>,
converted to editable format by <a href="http://www.mplayerhq.hu/">mencoder</a>
(lives can't directly open seom files),
editing (glued, fading between parts) thanks to
<a href="http://lives.sourceforge.net/">Lives (Linux Video Editing System)</a>.

<?php
  if (!IS_GEN_LOCAL) {
    $counter = php_counter("movies", TRUE);
  };

  common_footer();
?>
