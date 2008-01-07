<?php
  require_once 'vrmlengine_functions.php';

  common_header("Kambi VRML game engine (overview for developers)", LANG_EN);

  $toc = new TableOfContents(
    array(
      new TocItem('Features', 'features'),
      new TocItem('Download sources', 'download_src'),
      new TocItem('Documentation', 'docs'),
      new TocItem('Automatic tests', 'tests')
    )
  );
?>

<?php echo pretty_heading('Kambi VRML game engine (overview for developers)',
  VERSION_KAMBI_VRML_GAME_ENGINE); ?>

<?php
  echo '<table align="right">' .
    '<tr><td>' . medium_image_progs_demo_core("fountain_only_materials.png", '&quot;The Fountain&quot; level with only materials') .
    '<tr><td>' . medium_image_progs_demo_core("fountain_shadows.png", '&quot;The Fountain&quot; level textured with shadows') .
    '<tr><td>' . medium_image_progs_demo_core("fountain_toon_shading.png", '&quot;The Fountain&quot; level with toon shading GLSL program') .
    '<tr><td>' . medium_image_progs_demo_core("fountain_bump_mapping_good_materials.png", '&quot;The Fountain&quot; level with bump mapping used') .
    '</table>';
?>

<p>Contents:
<?php echo $toc->html_toc(); ?>

<?php echo $toc->html_section(); ?>

<p>This is an open-source game engine written in ObjectPascal.
Features include:</p>

<ul>
  <li><b>Optimized OpenGL rendering</b> of models in
    <b>VRML 1.0 and 2.0 (aka VRML 97)</b> formats.</li>

  <li><b>3DS, MD3, OBJ</b> file formats are also supported. They can be loaded,
    and converted to VRML 1.0.</li>

  <li><b>Animations</b> are supported, by interpolation.</li>

  <li>Octrees are used for various <b>collision detection</b> tasks.</li>

  <li><b>Shadows</b> by shadow volumes (full implementation, with z-fail / z-pass
    switching, silhouette detection etc.).</li>

  <li><b><?php echo a_href_page_hashlink('Bump mapping',
    'kambi_vrml_extensions', 'ext_bump_mapping'); ?></b> (internally using various
    implementations, depending on whether hardware supports GLSL or not;
    for most primitive method, basic multitexturing with 2 texture units is enough
    &mdash; so will run on pretty much any existing hardware).</li>

  <li><b>Shaders</b>. There are classes to easily use ARB fragment / vertex programs
    and GLSL shaders. Most important, you can
    <?php echo a_href_page_hashlink('add and control GLSL shaders from VRML',
    'kambi_vrml_extensions', 'ext_shaders'); ?>.
    So GLSL shaders are fully available
    for model designers, programmer doesn't have to do anything.

  <li>GLWindow unit is available to easily <b>create windows with OpenGL
    context</b>. The intention of this unit is to be something like glut,
    but magnitudes better &mdash; using clean ObjectPascal, for start.
    Also it allows you to easily create menu bars, open/save file and similar
    dialogs that are implemented using native controls (GTK (1.0 or 2.0, and yes,
    GTK 2.0 version is perfectly stable and adviced) or WinAPI).</li>

  <li>Reading and writing of <b>images</b> in various formats, processing them
    and using as OpenGL textures. Besides many common image formats
    (png, jpg, ppm, bmp, just for starters), included is also support for
    RGBE format (Radiance HDR format).</li>

  <li>Handling of <b>fonts</b>, including rendering them with OpenGL,
    as bitmap or outline (3D) fonts.</li>

  <li><b>3D sound</b> by OpenAL helpers, including intelligent OpenAL sound manager
    and OggVorbis format handling.</li>

  <li><b>Ray-tracer</b> based on VRML models is implemented.</li>

  <li>The engine is <b>portable</b>. Currently tested and used on Linux,
    FreeBSD, Mac OS X and Windows (all i386), and Linux on x86_64.
    Porters/testers for other OS/processors are welcome,
    the engine should be able to run on all modern OSes supported by FPC.</li>

  <li>Engine components are independent when possible.
    For example, you can only take VRML / 3DS / MD3 loading and processing
    code, and write the rendering yourself. Or you can use our OpenGL rendering,
    but still initialize OpenGL context yourself (no requirement to do it
    by our <tt>GLWindow</tt> unit). And so on.
    Of course, ultimately you can just use everything from our engine,
    nicely integrated &mdash; but the point is that you don't have to.</li>

  <!-- <li>Evaluating mathematical expressions -->
  <!-- li>Curves handling.</li -->
  <!--
      <li>ParsingPars, unit to parse command-line options

      <li>VectorMath, unit with many vector-and-matrix operations,
        mainly for 3d graphics

      <li>MathExpr, parsing and evaluating mathematical expressions

      <li>TDynXxxArray classes, something like richer dynamic arrays,
        done like "simulated" C++ templates
  -->
</ul>

<p>The engine was used to develop all programs on these pages.
It should be compiled by <a href="http://www.freepascal.org">FreePascal</a>.</p>


<?php echo $toc->html_section(); ?>

<p><?php echo a_href_page('Download sources of the engine and many related
programs/demos', 'sources'); ?>.</p>

<?php echo $toc->html_section(); ?>

<ul>
  <li><?php echo a_href_page('VRML engine reference (generated by pasdoc)',
    'reference') ?>.</li>
  <li><?php echo a_href_page("VRML engine documentation",
    'vrml_engine_doc'); ?> (more general overview of how the engine works).</li>
</ul>

<?php echo $toc->html_section(); ?>

<p>I'm managing a suite of automatic tests,
in the spirit of <a href="http://www.extremeprogramming.org/">Extreme Programming</a>.
On 2005-04-25 I converted my tests to use
<a href="http://camelos.sourceforge.net/fpcUnit.html">fpcunit</a>
(this is a close FPC analogy to <a href="http://www.junit.org/">JUnit for Java</a>)
and it's <a href="http://www.lazarus.freepascal.org/">Lazarus</a> GUI runner.

<p>The tests are included with the rest of engine sources,
see subdirectory <tt>tests/</tt>. This is a GUI program, so you can
compile it from Lazarus. You can also compile a console version
(that doesn't require any part of Lazarus LCL) by <tt>compile_console.sh</tt>
script inside.

<p>I will not give you a compiled executable of the testing program
(after all, it would have little sense, because all tests would succeed,
unless there's some problem specific to your OS configuration),
but I am generous enough to show you a snapshot of a happy test_kambi_units
program after successfully running all 33 tests:<br>
<?php echo
  medium_image_progs_demo('test_kambi_units_screen_demo.png', 'test_kambi_units', false)
?>

<?php
  if (!IS_GEN_LOCAL) {
    $counter = php_counter("kambi_vrml_game_engine", TRUE);
  };

  common_footer();
?>