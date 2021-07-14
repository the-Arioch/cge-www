<p>Another option is to <a href="https://github.com/castle-engine/castle-engine/wiki/FpMake">build and install the engine using FpMake</a>.

------------------------------------------------------------------------------
    //new TocItem('Alternatives', 'bare_fpc'),

<?php /*

<?php echo $toc->html_section(); ?>

<p>If you don't use Lazarus (only command-line FPC):

<p>Our engine can be used without the LCL (<i>Lazarus Component Library</i>)
through the
<?php api_link('TCastleWindowBase', 'CastleWindow.TCastleWindowBase.html'); ?> class.
To compile the engine and applications without the help of Lazarus,
you have a couple of options:

<ol>
  <li><p>We advice using our
    <a href="https://github.com/castle-engine/castle-engine/wiki/Build-Tool">build tool</a>
    to compile and package your games. The build tool reads the project
    configuration from the <a href="https://github.com/castle-engine/castle-engine/wiki/CastleEngineManifest.xml-examples">CastleEngineManifest.xml</a> file.
    It provides a lot of cool options, e.g. it can easily
    package your Android or iOS game, or prepare compressed versions of your textures.
    Try it out on the command-line:
    <!-- First compile the build tool itself (<code>./tools/build-tool/castle-engine_compile.sh</code>), -->
    <!-- move  -->

<pre>
tools/build-tool/castle-engine_compile.sh
<span class="xml_highlight_comment"># Line below is just an example for Unix, the goal is to put castle-engine binary on $PATH</span>
sudo mv tools/build-tool/castle-engine /usr/local/bin
<span class="xml_highlight_comment"># Line below is just an example for Unix, the goal is to define $CASTLE_ENGINE_PATH</span>
export CASTLE_ENGINE_PATH=`pwd`
<span class="xml_highlight_comment"># Test that it works!</span>
cd examples/fps_game/
castle-engine compile
</pre>

  <li><p>Or you can use a simple shell script that calls FPC with proper
    command-line options. Make sure to pass to FPC file <code>castle-fpc.cfg</code>
    that contains engine paths and compilation options.
    Just try compiling any example program this way, for example to compile
    <code>examples/fps_game/fps_game.lpr</code> do this:

<pre>
cd examples/fps_game/
./fps_game_compile.sh
</pre>

    <p>And run the resulting executable (run <code>./fps_game</code>
    on Unix, or <code>fps_game.exe</code> on Windows).
    You can use a similar approach as the <code>fps_game_compile.sh</code>
    script for your own programs.

    <!-- you can also do <code>make examples</code> at top-level -->

</ol>

<!--
The explanations that actually the engine
main OpenGL initialization method is <b>not</b> the Lazarus TOpenGLControl
takes too much space.

<p>There are also some Lazarus packages and examples (e.g. to extend Lazarus
<code>TOpenGLControl</code> component), they have to be compiled from
within Lazarus. Although note that the engine doesn't require LCL
for anything.
these are not an
essential part of the engine for now.
The main way for
initializing OpenGL for games is by CastleWindow unit that doesn't depend on
any Lazarus units. -->

*/ ?>

------------------------------------------------------------------------------
    new TocItem('Install the libraries', 'libraries'),
    new TocItem('Read the manual', 'manual'),

<?php echo $toc->html_section(); ?>

<p>Programs developed using our engine use some external libraries.

<ul>
  <li><p><b>On Windows</b> the libraries (<code>dll</code> files) are in the downloaded engine archive.

    <p><i>If you use our <a href="manual_editor.php">editor</a> or <a href="https://github.com/castle-engine/castle-engine/wiki/Build-Tool">command-line build tool</a>, the <code>dll</code> files will be automatically copied alongside your <code>exe</code> file, so you don't have to do anything. Seriously, you can stop reading now :)</i>

    <p>If you use some other method of compilation, you need to manually make sure that the <code>dll</code> files are in the correct place.

    <p>The <code>dll</code> files are in:

    <ul>
      <li>(32-bit) <a href="https://github.com/castle-engine/castle-engine/tree/master/tools/build-tool/data/external_libraries/i386-win32">castle_game_engine/tools/build-tool/data/external_libraries/i386-win32/</a> or

      <li>(64-bit) <a href="https://github.com/castle-engine/castle-engine/tree/master/tools/build-tool/data/external_libraries/x86_64-win64">castle_game_engine/tools/build-tool/data/external_libraries/x86_64-win64/</a> .
    </ul>

    <p>You can copy these <code>dll</code> files to every directory with <code>exe</code> files of your application.

    <p>Or you can modify your <code>PATH</code> environment variable to include the directory
    where the <code>dll</code> files are. If you're not sure how to set the environment variable, search the Internet (e.g. <a href="https://www.computerhope.com/issues/ch000549.htm">these are quick instructions how to do it on various Windows versions</a>).
    Remember to restart the appropriate programs, to make them use the new
    value of <code>PATH</code>.

    <p>Be sure to use the <code>dll</code> files corresponding to your target platform. For example, if you use FPC/Lazarus for 32-bits, then you make executable for 32-bits (by default), and you should use <code>dll</code> for 32-bits. <i>Even if you work on a 64-bit Windows.</i>

    <!--If in doubt, just try the other ones:)-->

  <li><p><b>On Linux and FreeBSD</b>, we use the following libraries:

    <ol>
      <li>OpenGL (<i>essential for the engine to work</i>; used to render)
      <li>LibPng (to open png files more efficiently)
      <li>ZLib (to unpack gzip files, also used by LibPng)
      <li>OpenAL (to play sound)
      <li>FreeType (to load font files)
      <li>VorbisFile (to load OggVorbis files)
    </ol>

    <p>The first 3 (OpenGL, LibPng, Zlib) are definitely present on all
    reasonable desktop installations.
    The others are typicallly installed too, but it will not hurt to document somewhere for users
    <i>"Please make sure you have these libraries installed: ..."</i>.

    <p>On your (developer) system, you will need the development versions of
    some of these libraries. This allows to build programs that link to these libraries.
    On Debian systems, this command should install everything you need:

    <pre>sudo apt install libgtk2.0-dev libgl1-mesa-dev</pre>

    <p>Note that we link to many libraries dynamically using <i>"dlopen"</i> Unix mechanism.
    So it is not necessary to install e.g. <code>libpng-dev</code> or <code>libfreetype6-dev</code>.

  <li><p><b>On Mac OS X</b>: <?php echo a_href_page('Mac OS X requirements are listed here',
    'macosx_requirements'); ?>.
</ul>

<!--
In general, for all OSes, see section
 in the documentation of programs and make sure that
you have appropriate libraries installed on your system.
-->

<?php echo $toc->html_section(); ?>

------------------------------------------------------------------------------

<p>From Lazarus, you can use the engine integrated
with Lazarus forms (and the rest of the <i>Lazarus Component Library</i>)
through the
<?php api_link('TCastleControlBase', 'CastleControl.TCastleControlBase.html'); ?> class.
Or you can use Lazarus only as an editor and debugger,
and use the engine without the Lazarus forms,
initializing the window using the
<?php api_link('TCastleWindowBase', 'CastleWindow.TCastleWindowBase.html'); ?> class.

------------------------------------------------------------------------------

<div class="centered-download-wrapper">
<div class="download jumbotron">
<a class="btn btn-primary btn-lg" href="<?php echo page_url('manual_intro'); ?>">Now go to our manual!</a>

<div style="margin-top: 1em;">..and create some cool games!:)

<p>It's really easy, and if you have any questions &mdash; please <a href="<?php echo FORUM_URL; ?>">ask on the forum</a>!
</div>

<?php echo download_donate_footer(); ?>
</div>
</div>

------------------------------------------------------------------------------

<!--p><a href="https://www.youtube.com/watch?v=rCPEOw8700c">Watch the movie showing the Lazarus installation process.</a-->

------------------------------------------------------------------------------

<?php echo $toc->html_section(); ?>

<p>If you like to learn by watching, enjoy this video introduction to the engine and editor:

<p>

<iframe width="560" height="315" src="https://www.youtube.com/embed/zdwN4mdQG_8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

------------------------------------------------------------------------------

<div class="centered-download-wrapper" style="text-align: left">
<div class="download jumbotron" style="text-align: center">
<a class="btn btn-primary btn-lg" href="<?php echo page_url('manual_intro'); ?>">Now go to our manual!</a>

<div style="margin-top: 1em;">..and create some cool games!:)

<p>If you have any questions <a href="talk.php">ask on the forum or chat</a>.
</div>

<?php echo download_donate_footer(); ?>
</div>
</div>
